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
            'trips'    => Trip::orderBy('name')->get(['id', 'name']),
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
                'trip_id'        => $validated['trip_id'],
                'date'           => $validated['date'],
                'organizer_id'   => auth()->id(),
                'remarks'        => $validated['remarks'] ?? null,
                'status'         => $validated['status'] ?? 'draft',
            ]);

            $totAdults = $totChildren = $totInfants = 0;
            $totAmount = 0;

            foreach ($validated['families'] ?? [] as $fam) {
                $family = new ProgramFamily($fam);
                $program->families()->save($family);

                $totAdults   += (int) ($fam['adults']   ?? 0);
                $totChildren += (int) ($fam['children'] ?? 0);
                $totInfants  += (int) ($fam['infants']  ?? 0);

                // NOTE: For now we sum raw values of currencies as "total_amount".
                // You can replace with conversion logic if needed.
                $totAmount += (float) ($fam['collect_egp'] ?? 0)
                           + (float) ($fam['collect_usd'] ?? 0)
                           + (float) ($fam['collect_eur'] ?? 0);
            }

            $program->update([
                'total_adults'   => $totAdults,
                'total_children' => $totChildren,
                'total_infants'  => $totInfants,
                'total_amount'   => $totAmount,
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
            'families.customer', 'families.hotel'
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
            'program'  => $tripProgram,
            'trips'    => Trip::orderBy('name')->get(['id', 'name']),
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
        $validated = $this->validateProgram($request);

        DB::transaction(function () use ($validated, $tripProgram) {
            $tripProgram->update([
                'trip_id'    => $validated['trip_id'],
                'date'       => $validated['date'],
                'organizer_id' => auth()->id(),
                'remarks'    => $validated['remarks'] ?? null,
                'status'     => $validated['status'] ?? $tripProgram->status,
            ]);

            // Replace all families for simplicity (atomic):
            $tripProgram->families()->delete();

            $totAdults = $totChildren = $totInfants = 0;
            $totAmount = 0;

            foreach ($validated['families'] ?? [] as $fam) {
                $tripProgram->families()->create($fam);

                $totAdults   += (int) ($fam['adults']   ?? 0);
                $totChildren += (int) ($fam['children'] ?? 0);
                $totInfants  += (int) ($fam['infants']  ?? 0);

                $totAmount += (float) ($fam['collect_egp'] ?? 0)
                           + (float) ($fam['collect_usd'] ?? 0)
                           + (float) ($fam['collect_eur'] ?? 0);
            }

            $tripProgram->update([
                'total_adults'   => $totAdults,
                'total_children' => $totChildren,
                'total_infants'  => $totInfants,
                'total_amount'   => $totAmount,
            ]);
        });

        return redirect()->route('trip-programs.index')->with('success', 'Trip program updated.');
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
     * Central validation (includes rule: either customer_id OR group_name must be provided per family)
     */
    protected function validateProgram(Request $request): array
    {
        $messages = [
            'families.*.customer_id.required_without' => 'Provide either Customer or Group Name.',
            'families.*.group_name.required_without'  => 'Provide either Group Name or Customer.',
        ];

        return $request->validate([
            // Section 1: Trip info
            'trip_id'    => ['required','exists:trips,id'],
            'date'       => ['required','date'],
            'organizer_id' => ['required','exists:users,id'],
            'status'     => ['nullable','in:draft,confirmed,done'],
            'remarks'    => ['nullable','string'],

            // Section 2: Families / Groups
            'families'                       => ['nullable','array'],
            'families.*.customer_id'         => ['nullable','exists:customers,id','required_without:families.*.group_name'],
            'families.*.group_name'          => ['nullable','string','required_without:families.*.customer_id'],
            'families.*.adults'              => ['nullable','integer','min:0'],
            'families.*.children'            => ['nullable','integer','min:0'],
            'families.*.infants'             => ['nullable','integer','min:0'],
            'families.*.hotel_id'            => ['nullable','exists:hotels,id'],
            'families.*.room_number'         => ['nullable','string','max:100'],
            'families.*.pickup_time'         => ['nullable','date_format:H:i'],
            'families.*.activity'            => ['nullable','string','max:50'],
            'families.*.size'                => ['nullable','string','max:50'],
            'families.*.nationality'         => ['nullable','string','max:100'],
            'families.*.boat_master'         => ['nullable','string','max:100'],
            'families.*.guide_name'          => ['nullable','string','max:100'],
            'families.*.transfer_name'       => ['nullable','string','max:100'],
            'families.*.transfer_phone'      => ['nullable','string','max:100'],
            'families.*.collect_egp'         => ['nullable','numeric','min:0'],
            'families.*.collect_usd'         => ['nullable','numeric','min:0'],
            'families.*.collect_eur'         => ['nullable','numeric','min:0'],
            'families.*.remarks'             => ['nullable','string'],
        ], $messages);
    }
}
