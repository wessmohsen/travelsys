@extends('layouts.app')
@section('content')
<div class="container-fluid">
    <h1>Top Customers</h1>
    <div class="card"><div class="card-body table-responsive">
        <table class="table table-bordered table-hover">
            <thead><tr><th>Customer</th><th>Email</th><th>Total Bookings</th></tr></thead>
            <tbody>@foreach($topCustomers as $customer)
                <tr><td>{{ $customer->name }}</td><td>{{ $customer->email }}</td><td>{{ $customer->bookings_count }}</td></tr>
            @endforeach</tbody>
        </table>
    </div></div>
</div>
@endsection
