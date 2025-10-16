<?php

namespace App\Http\Controllers;

use App\Models\SubCustomer;
use App\Models\Customer;
use App\Models\Hotel;
use Illuminate\Http\Request;

class SubCustomerController extends Controller
{
    public function index(Customer $customer)
    {
        $items = $customer->subCustomers()->with('hotel')->paginate(10);
        return view('subcustomers.index', compact('items', 'customer'));
    }

    public function create(Customer $customer)
    {
        $hotels = Hotel::all();
        return view('subcustomers.create', compact('customer', 'hotels'));
    }

    public function store(Request $request, Customer $customer)
    {
        $request->validate([
            'relation_type'   => 'required|in:adult,child,infant',
            'first_name'      => 'required|string|max:255',
            'last_name'       => 'nullable|string|max:255',
            'email'           => 'nullable|email',
            'hotel_id'        => 'nullable|exists:hotels,id',
            'room_number'     => 'nullable|string|max:100',
            'responsible_name'=> 'nullable|string|max:255',
        ]);

        $customer->subCustomers()->create($request->all());

        return redirect()
            ->route('customers.show', $customer->id)
            ->with('success', 'Family member added successfully.');
    }

    public function show(Customer $customer, SubCustomer $subcustomer)
    {
        $subcustomer->load('hotel');
        return view('subcustomers.show', compact('customer', 'subcustomer'));
    }

    public function edit(Customer $customer, SubCustomer $subcustomer)
    {
        $item   = $subcustomer; // نفس متغير الموديولات القديمة
        $hotels = Hotel::all();
        return view('subcustomers.edit', compact('customer', 'item', 'hotels'));
    }

    public function update(Request $request, Customer $customer, SubCustomer $subcustomer)
    {
        $request->validate([
            'relation_type'   => 'required|in:adult,child,infant',
            'first_name'      => 'required|string|max:255',
            'last_name'       => 'nullable|string|max:255',
            'email'           => 'nullable|email',
            'hotel_id'        => 'nullable|exists:hotels,id',
            'room_number'     => 'nullable|string|max:100',
            'responsible_name'=> 'nullable|string|max:255',
        ]);

        $subcustomer->update($request->all());

        return redirect()
            ->route('customers.show', $customer->id)
            ->with('success', 'Family member updated successfully.');
    }

    public function destroy(Customer $customer, SubCustomer $subcustomer)
    {
        $subcustomer->delete();
        return redirect()
            ->route('customers.show', $customer->id)
            ->with('success', 'Family member deleted successfully.');
    }
}
