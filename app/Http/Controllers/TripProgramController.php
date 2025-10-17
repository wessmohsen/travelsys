<?php

namespace App\Http\Controllers;

use App\Models\{TripProgram, ProgramFamily, Trip, Customer, Hotel, User, Boat, Agency, Guide, TransferContract};
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
            'transferContracts' => TransferContract::where('status', 'active')->with('driver')->orderBy('company_name')->get(['id', 'company_name', 'from', 'to', 'contract_type', 'driver_id']), // Pass active transfer contracts with driver details
        ]);
    }

    /**
     * store() → save trip program + families/groups
     * Auto-calc totals & total_amount
     */
    public function store(Request $request)
    {
        $validated = $this->validateProgram($request);

        // Debug: Log the customers data
        \Log::info('=== STORE DEBUG ===');
        \Log::info('Request families:', ['families' => $request->input('families')]);
        if (isset($validated['families']) && is_array($validated['families'])) {
            foreach ($validated['families'] as $idx => $fam) {
                if (isset($fam['customers'])) {
                    \Log::info("Family {$idx} customers:", ['customers' => $fam['customers'], 'count' => count($fam['customers'])]);
                }
            }
        }

        DB::transaction(function () use ($validated, $request) {
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
                // Extract customers array
                $customerIds = [];
                $groupNames = [];

                if (isset($fam['customers']) && is_array($fam['customers']) && !empty($fam['customers'])) {
                    foreach ($fam['customers'] as $customerData) {
                        if (strpos($customerData, 'customer:') === 0) {
                            // It's a customer ID
                            $customerIds[] = (int) str_replace('customer:', '', $customerData);
                        } elseif (strpos($customerData, 'group:') === 0) {
                            // It's a group name
                            $groupNames[] = str_replace('group:', '', $customerData);
                        }
                    }
                }

                // Remove the customers array as it's not a database field
                if (isset($fam['customers'])) {
                    unset($fam['customers']);
                }

                // Store customer IDs as array (Laravel will auto json_encode with the cast)
                $fam['customer_id'] = !empty($customerIds) ? $customerIds : null;

                // Store group names as comma-separated string, or null if empty
                $fam['group_name'] = !empty($groupNames) ? implode(', ', $groupNames) : null;

                $family = new ProgramFamily($fam);
                $program->families()->save($family);

                $totAdults += (int) ($fam['adults'] ?? 0);
                $totChildren += (int) ($fam['children'] ?? 0);
                $totInfants += (int) ($fam['infants'] ?? 0);

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
            'trip',
            'families.hotel',
            'families.transferContract.driver'
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
        // Don't eager load customer since customer_id is now an array
        $tripProgram->load(['families']);

        return view('trip_programs.edit', [
            'program' => $tripProgram,
            'trips' => Trip::orderBy('name')->get(['id', 'name']),
            'organizers' => User::orderBy('name')->get(['id', 'name']), // Add organizers for the dropdown
            'hotels' => Hotel::orderBy('name')->get(['id', 'name']), // Pass hotels for the dropdown
            'boats' => Boat::orderBy('name')->get(['id', 'name']), // Pass boats for the dropdown
            'agencies' => Agency::orderBy('name')->get(['id', 'name']), // Pass agencies for the dropdown
            'guides' => Guide::orderBy('name')->get(['id', 'name']), // Pass guides for the dropdown
            'transferContracts' => TransferContract::where('status', 'active')->with('driver')->orderBy('company_name')->get(['id', 'company_name', 'from', 'to', 'contract_type', 'driver_id']), // Pass active transfer contracts with driver details
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

        DB::transaction(function () use ($validated, $tripProgram) {
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

            if (isset($validated['families']) && is_array($validated['families'])) {
                foreach ($validated['families'] as $familyData) {
                    // Extract customers array
                    $customerIds = [];
                    $groupNames = [];

                    if (isset($familyData['customers']) && is_array($familyData['customers']) && !empty($familyData['customers'])) {
                        foreach ($familyData['customers'] as $customerData) {
                            if (strpos($customerData, 'customer:') === 0) {
                                // It's a customer ID
                                $customerIds[] = (int) str_replace('customer:', '', $customerData);
                            } elseif (strpos($customerData, 'group:') === 0) {
                                // It's a group name
                                $groupNames[] = str_replace('group:', '', $customerData);
                            }
                        }
                    }

                    // Remove the customers array as it's not a database field
                    if (isset($familyData['customers'])) {
                        unset($familyData['customers']);
                    }

                    // Store customer IDs as array (Laravel will auto json_encode with the cast)
                    $familyData['customer_id'] = !empty($customerIds) ? $customerIds : null;

                    // Store group names as comma-separated string, or null if empty
                    $familyData['group_name'] = !empty($groupNames) ? implode(', ', $groupNames) : null;

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
                        $newFamily = ProgramFamily::create($familyData);
                        $submittedFamilyIds[] = $newFamily->id;
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
            'families.*.id' => 'nullable|integer',
            'families.*.customer_id' => 'nullable|exists:customers,id',
            'families.*.group_name' => 'nullable|string',
            'families.*.customers' => 'nullable|array',
            'families.*.customers.*' => 'nullable|string',
            'families.*.agency_id' => 'nullable|exists:agencies,id',
            'families.*.adults' => 'nullable|integer|min:0',
            'families.*.children' => 'nullable|integer|min:0',
            'families.*.infants' => 'nullable|integer|min:0',
            'families.*.hotel_id' => 'nullable|exists:hotels,id',
            'families.*.room_number' => 'nullable|string',
            'families.*.pickup_time' => 'nullable',
            'families.*.activity' => 'nullable|string',
            'families.*.size' => 'nullable|string',
            'families.*.nationality' => 'nullable|string',
            'families.*.boat_master' => 'nullable|string',
            'families.*.boat_id' => 'nullable|exists:boats,id',
            'families.*.guide_id' => 'nullable|exists:guides,id',
            'families.*.transfer_contract_id' => 'nullable|exists:transfer_contracts,id',
            'families.*.vehicle_id' => 'nullable|exists:vehicles,id',
            'families.*.collect_egp' => 'nullable|numeric|min:0',
            'families.*.collect_usd' => 'nullable|numeric|min:0',
            'families.*.collect_eur' => 'nullable|numeric|min:0',
            'families.*.remarks' => 'nullable|string',
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
