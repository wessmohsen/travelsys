<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Hotel;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index()
    {
        $items = Customer::with('hotel')->paginate(10);
        return view('customers.index', compact('items'));
    }

    public function create()
    {
        $hotels = Hotel::all();
        return view('customers.create', compact('hotels'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'type' => 'required|in:individual,family',
            'first_name' => 'required|string|max:255',
            'last_name' => 'nullable|string|max:255',
            'email' => 'nullable|email|unique:customers,email',
            'hotel_id' => 'nullable|exists:hotels,id',
            'room_number' => 'nullable|string|max:100',
        ]);

        // ✅ Map 'type' to 'customer_type'
        $data = $request->all();
        $data['customer_type'] = $data['type'];
        unset($data['type']);

        Customer::create($data);

        return redirect()
            ->route('customers.index')
            ->with('success', 'Customer created successfully.');
    }

    public function show(Customer $customer)
    {
        $customer->load(['hotel', 'subCustomers.hotel']);
        return view('customers.show', compact('customer'));
    }

    public function edit(Customer $customer)
    {
        $item = $customer;
        $hotels = \App\Models\Hotel::all();
        return view('customers.edit', compact('item', 'hotels'));
    }

    public function update(Request $request, Customer $customer)
    {
        $request->validate([
            'type' => 'required|in:individual,family',
            'first_name' => 'required|string|max:255',
            'last_name' => 'nullable|string|max:255',
            'email' => 'nullable|email|unique:customers,email,' . $customer->id,
            'hotel_id' => 'nullable|exists:hotels,id',
            'room_number' => 'nullable|string|max:100',
        ]);

        // ✅ Map 'type' to 'customer_type'
        $data = $request->all();
        $data['customer_type'] = $data['type'];
        unset($data['type']);

        $customer->update($data);

        return redirect()
            ->route('customers.show', $customer->id)
            ->with('success', 'Customer updated successfully.');
    }

    public function destroy(Customer $customer)
    {
        $customer->delete();
        return redirect()
            ->route('customers.index')
            ->with('success', 'Customer deleted successfully.');
    }

    // ✅ Ajax Search للـ Select2
    public function search(Request $request)
    {
        $search = $request->get('q', '');

        $customers = Customer::query()
            ->whereRaw("CONCAT(first_name, ' ', last_name) LIKE ?", ["%{$search}%"])
            ->limit(10)
            ->get();

        $results = $customers->map(function ($customer) {
            return [
                'id' => $customer->id,
                'text' => $customer->name, // accessor
            ];
        });

        return response()->json(['results' => $results]);
    }

    public function deleteSubCustomers($customerId)
    {
        $customer = Customer::findOrFail($customerId);

        // Delete all sub-customers associated with this customer
        $customer->subCustomers()->delete();

        return response()->json(['message' => 'Sub-customers deleted successfully.']);
    }
}
