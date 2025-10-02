<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index()
    {
        $items = Customer::paginate(10);
        return view('customers.index', compact('items'));
    }

    public function create()
    {
        return view('customers.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'first_name' => 'required',
            'last_name'  => 'required',
            'email'      => 'required|email|unique:customers',
        ]);

        Customer::create($request->all());

        return redirect()->route('customers.index')->with('success', 'Customer created successfully.');
    }

    public function show(Customer $customer)
    {
        return view('customers.show', compact('customer'));
    }

    public function edit(Customer $customer)
    {
        // نستخدم نفس الـ variable "item" زي باقي الموديولات
        $item = $customer;
        return view('customers.edit', compact('item'));
    }

    public function update(Request $request, Customer $customer)
    {
        $request->validate([
            'first_name' => 'required',
            'last_name'  => 'required',
            'email'      => 'required|email|unique:customers,email,' . $customer->id,
        ]);

        $customer->update($request->all());

        return redirect()->route('customers.index')->with('success', 'Customer updated successfully.');
    }

    public function destroy(Customer $customer)
    {
        $customer->delete();
        return redirect()->route('customers.index')->with('success', 'Customer deleted successfully.');
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
                'text' => $customer->name, // accessor: first_name + last_name
            ];
        });

        return response()->json(['results' => $results]);
    }
}
