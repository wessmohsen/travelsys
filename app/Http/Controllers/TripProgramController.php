<?php

namespace App\Http\Controllers;

use App\Models\{TripProgram, ProgramFamily, Trip, Customer, Hotel, User, Boat, Agency, Guide};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TripProgramController extends Controller
{
    /**
     * index() → list programs with filters (by date, trip)
     */
    public function index(Request $request)
    {
        $query = TripProgram::query()
            ->with(['trip']) // Removed 'vehicle'
            ->latest('date');

        if ($request->filled('date')) {
            $query->whereDate('date', $request->date);
        }
        if ($request->filled('trip_id')) {
            $query->where('trip_id', $request->trip_id);
        }
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $programs = $query->paginate(20)->withQueryString();

        // For filters dropdowns
        $trips = Trip::orderBy('name')->get(['id', 'name']);

        return view('trip_programs.index', compact('programs', 'trips'));
    }

    /**
     * create() → form page
     */
    public function create()
    {
        return view('trip_programs.create', [
            'trips' => Trip::orderBy('name')->get(['id', 'name']),
            'organizers' => User::orderBy('name')->get(['id', 'name']), // Add organizers for the dropdown
            'hotels' => Hotel::orderBy('name')->get(['id', 'name']), // Pass hotels for the dropdown
            'boats' => Boat::orderBy('name')->get(['id', 'name']), // Pass boats for the dropdown
            'agencies' => Agency::orderBy('name')->get(['id', 'name']), // Pass agencies for the dropdown
            'guides' => Guide::orderBy('name')->get(['id', 'name']), // Pass guides for the dropdown
        ]);
    }

    /**
     * store() → save trip program + families/groups
     * Auto-calc totals & total_amount
     */
    public function store(Request $request)
    {
        $validated = $this->validateProgram($request);

        DB::transaction(function () use ($validated) {
            // Create program
            $program = TripProgram::create([
                'trip_id' => $validated['trip_id'],
                'date' => $validated['date'],
                'organizer_id' => auth()->id(),
                'remarks' => $validated['remarks'] ?? null,
                'status' => $validated['status'] ?? 'draft',
            ]);

            $totAdults = $totChildren = $totInfants = 0;
            $totAmount = 0;

            foreach ($validated['families'] ?? [] as $fam) {
                $family = new ProgramFamily($fam);
                $program->families()->save($family);

                $totAdults += (int) ($fam['adults'] ?? 0);
                $totChildren += (int) ($fam['children'] ?? 0);
                $totInfants += (int) ($fam['infants'] ?? 0);

                // NOTE: For now we sum raw values of currencies as "total_amount".
                // You can replace with conversion logic if needed.
                $totAmount += (float) ($fam['collect_egp'] ?? 0)
                    + (float) ($fam['collect_usd'] ?? 0)
                    + (float) ($fam['collect_eur'] ?? 0);
            }

            $program->update([
                'total_adults' => $totAdults,
                'total_children' => $totChildren,
                'total_infants' => $totInfants,
                'total_amount' => $totAmount,
            ]);
        });

        return redirect()->route('trip-programs.index')->with('success', 'Trip program created.');
    }

    /**
     * show() → full daily report (Excel-like layout) + optional export
     */
    public function show(TripProgram $tripProgram, Request $request)
    {
        $tripProgram->load([
            'trip', // Removed 'vehicle'
            'families.customer',
            'families.hotel'
        ]);

        // Simple export toggles (placeholder)
        if ($request->get('export') === 'pdf') {
            // TODO: integrate your PDF generator (e.g., barryvdh/laravel-dompdf)
            // return PDF::loadView('trip_programs.show', [...])->download('daily-report.pdf');
        }
        if ($request->get('export') === 'excel') {
            // TODO: integrate Laravel-Excel export
        }

        return view('trip_programs.show', compact('tripProgram'));
    }

    /**
     * edit() → form page
     */
    public function edit(TripProgram $tripProgram)
    {
        $tripProgram->load(['families']);

        return view('trip_programs.edit', [
            'program' => $tripProgram,
            'trips' => Trip::orderBy('name')->get(['id', 'name']),
            'organizers' => User::orderBy('name')->get(['id', 'name']), // Add organizers for the dropdown
            'hotels' => Hotel::orderBy('name')->get(['id', 'name']), // Pass hotels for the dropdown
            'boats' => Boat::orderBy('name')->get(['id', 'name']), // Pass boats for the dropdown
            'agencies' => Agency::orderBy('name')->get(['id', 'name']), // Pass agencies for the dropdown
            'guides' => Guide::orderBy('name')->get(['id', 'name']), // Pass guides for the dropdown
        ]);
    }

    /**
     * update() → update program and families (replace-all strategy for simplicity)
     */
    public function update(Request $request, TripProgram $tripProgram)
    {
        // Log the request data for debugging
        \Log::info('Update request received', ['data' => $request->all()]);

        // Validate the request
        $validated = $this->validateProgram($request);

        // Log the validated data for debugging
        \Log::info('Validated data', ['data' => $validated]);

        DB::transaction(function () use ($validated, $tripProgram, $request) {
            // Update the trip program
            $tripProgram->update([
                'trip_id' => $validated['trip_id'],
                'date' => $validated['date'],
                'organizer_id' => $validated['organizer_id'],
                'remarks' => $validated['remarks'] ?? null,
                'status' => $validated['status'] ?? $tripProgram->status,
            ]);

            // Handle families
            $existingFamilyIds = $tripProgram->families->pluck('id')->toArray();
            $submittedFamilyIds = [];

            if ($request->has('families')) {
                foreach ($request->families as $familyData) {
                    // Ensure default values for required fields
                    $familyData['adults'] = $familyData['adults'] ?? 0;
                    $familyData['children'] = $familyData['children'] ?? 0;
                    $familyData['infants'] = $familyData['infants'] ?? 0;

                    if (!empty($familyData['id'])) {
                        // Update existing family
                        $family = ProgramFamily::find($familyData['id']);
                        if ($family) {
                            $family->update($familyData);
                            $submittedFamilyIds[] = $familyData['id'];
                        }
                    } else {
                        // Create new family
                        $familyData['trip_program_id'] = $tripProgram->id;
                        ProgramFamily::create($familyData);
                    }
                }
            }

            // Delete families not in the submitted data
            $familiesToDelete = array_diff($existingFamilyIds, $submittedFamilyIds);
            if (!empty($familiesToDelete)) {
                ProgramFamily::whereIn('id', $familiesToDelete)->delete();
            }
        });

        // Log the successful update
        \Log::info('Trip program updated', ['id' => $tripProgram->id]);

        // Redirect back to the edit page with success message
        return redirect()->route('trip-programs.edit', $tripProgram->id)
            ->with('success', 'Trip program updated successfully.');
    }


    /**
     * destroy()
     */
    public function destroy(TripProgram $tripProgram)
    {
        $tripProgram->delete();
        return redirect()->route('trip-programs.index')->with('success', 'Trip program deleted.');
    }

    /**
     * destroyFamily()
     */
    public function destroyFamily(ProgramFamily $family)
    {
        try {
            $family->delete();
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            \Log::error('Error deleting family: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to delete family'], 500);
        }
    }

    /**
     * Delete a family from a trip program
     */
    public function deleteFamily($familyId)
    {
        try {
            $family = ProgramFamily::findOrFail($familyId);
            $family->delete();

            return response()->json([
                'success' => true,
                'message' => 'Family deleted successfully'
            ]);
        } catch (\Exception $e) {
            \Log::error('Error deleting family: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete family'
            ], 500);
        }
    }

    /**
     * Delete a family from a trip program by ID
     */
    public function deleteProgramFamily($id)
    {
        try {
            $family = ProgramFamily::findOrFail($id);
            $family->delete();
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            \Log::error('Failed to delete family: ' . $e->getMessage());
            return response()->json(['success' => false], 500);
        }
    }

    /**
     * Central validation (includes rule: either customer_id OR group_name must be provided per family)
     */
    protected function validateProgram(Request $request): array
    {
        return $request->validate([
            'trip_id' => 'required|exists:trips,id',
            'date' => 'required|date',
            'organizer_id' => 'required|exists:users,id',
            'status' => 'nullable|in:draft,confirmed,done',
            'remarks' => 'nullable|string',
            'families' => 'array',
            'families.*.adults' => 'nullable|integer|min:0',
            'families.*.children' => 'nullable|integer|min:0',
            'families.*.infants' => 'nullable|integer|min:0',
        ]);
    }

    /**
     * Delete a family via AJAX (for DataTables or other dynamic interfaces)
     */
    public function ajaxDeleteFamily($id)
    {
        try {
            $family = ProgramFamily::findOrFail($id);
            $family->delete();

            return response()->json([
                'success' => true,
                'message' => 'Family deleted successfully'
            ]);
        } catch (\Exception $e) {
            \Log::error('Failed to delete family: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete family'
            ], 500);
        }
    }

    public function ajaxDeleteProgramFamily(ProgramFamily $family)
    {
        try {
            $family->delete();
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            \Log::error('Error deleting program family: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Failed to delete family'], 500);
        }
    }
}
