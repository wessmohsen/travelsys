<?php

namespace App\Http\Controllers;

use App\Models\TransferContract;
use App\Models\Driver;
use App\Models\Vehicle;
use App\Models\Agency;
use Illuminate\Http\Request;

class TransferContractController extends Controller
{
    public function index()
    {
        $items = TransferContract::with(['driver', 'vehicle'])->paginate(10);
        return view('transfercontracts.index', compact('items'));
    }

    public function create()
    {
        $drivers = Driver::all();
        $vehicles = Vehicle::all();
        $companies = Agency::all();

        return view('transfercontracts.create', compact('drivers', 'vehicles', 'companies'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'driver_id' => 'nullable|exists:drivers,id',
            'vehicle_id' => 'nullable|exists:vehicles,id',
            'company_id' => 'nullable|exists:agencies,id',
            'contract_type' => 'required|string',
            'from' => 'required|string',
            'to' => 'required|string',
            'contract_date' => 'required|date',
            'status' => 'required|in:active,inactive',
        ]);

        TransferContract::create($request->all());

        return redirect()->route('transfercontracts.index')->with('success', 'Contract created successfully');
    }

    public function show(TransferContract $transfercontract)
    {
        $item = $transfercontract; // ✅ علشان نستخدم $item في show.blade.php
        return view('transfercontracts.show', compact('item'));
    }

    public function edit(TransferContract $transfercontract)
    {
        $item = $transfercontract; // ✅ علشان نستخدم $item في edit.blade.php
        $drivers = Driver::all();
        $vehicles = Vehicle::all();
        $companies = Agency::all();

        return view('transfercontracts.edit', compact('item', 'drivers', 'vehicles', 'companies'));
    }

    public function update(Request $request, TransferContract $transfercontract)
    {
        $request->validate([
            'driver_id' => 'nullable|exists:drivers,id',
            'vehicle_id' => 'nullable|exists:vehicles,id',
            'company_name' => 'nullable|string|max:255',
            'from' => 'required|string|max:255',
            'to' => 'required|string|max:255',
            'contract_type' => 'required|in:driver,company',
            'contract_date' => 'required|date',
            'status' => 'required|in:active,inactive', // ✅ هنا التغيير
        ]);


        $transfercontract->update($request->all());

        return redirect()->route('transfercontracts.index')->with('success', 'Contract updated successfully');
    }

    public function destroy(TransferContract $transfercontract)
    {
        $transfercontract->delete();
        return redirect()->route('transfercontracts.index')->with('success', 'Contract deleted successfully');
    }
}
