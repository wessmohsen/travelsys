@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <h1>Family Member Details</h1>
    @include('partials.flash')

    <table class="table table-bordered">
        <tr>
            <th>Relation Type</th>
            <td>{{ ucfirst($subcustomer->relation_type) }}</td>
        </tr>
        <tr>
            <th>Full Name</th>
            <td>{{ $subcustomer->first_name }} {{ $subcustomer->last_name }}</td>
        </tr>
        <tr>
            <th>Email</th>
            <td>{{ $subcustomer->email ?? '-' }}</td>
        </tr>
        <tr>
            <th>Hotel</th>
            <td>{{ $subcustomer->hotel->name ?? '-' }}</td>
        </tr>
        <tr>
            <th>Room</th>
            <td>{{ $subcustomer->room_number ?? '-' }}</td>
        </tr>
        <tr>
            <th>Responsible Name</th>
            <td>{{ $subcustomer->responsible_name ?? '-' }}</td>
        </tr>
    </table>

    <a href="{{ route('customers.subcustomers.edit', [$customer->id, $subcustomer->id]) }}" class="btn btn-warning">
        Edit
    </a>
    <a href="{{ route('customers.show', $customer->id) }}" class="btn btn-secondary">
        Back
    </a>
</div>
@endsection
