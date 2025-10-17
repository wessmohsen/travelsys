@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <h1>Customers</h1>
    @include('partials.breadcrumbs')
    
    @can('create-customers')
    <a href="{{ route('customers.create') }}" class="btn btn-success mb-3">+ Add Customer</a>
    @endcan

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Country</th>
                @canany(['edit-customers', 'delete-customers'])
                <th>Actions</th>
                @endcanany
            </tr>
        </thead>
        <tbody>
            @foreach($items as $customer)
            <tr>
                <td>{{ $customer->id }}</td>
                <td>{{ $customer->first_name }} {{ $customer->last_name }}</td>
                <td>{{ $customer->email }}</td>
                <td>{{ $customer->phone }}</td>
                <td>{{ $customer->country }}</td>
                @canany(['edit-customers', 'delete-customers'])
                <td>
                    @can('view-customers')
                    <a href="{{ route('customers.show', $customer->id) }}" class="btn btn-info btn-sm">View</a>
                    @endcan
                    
                    @can('edit-customers')
                    <a href="{{ route('customers.edit', $customer->id) }}" class="btn btn-primary btn-sm">Edit</a>
                    @endcan
                    
                    @can('delete-customers')
                    <form action="{{ route('customers.destroy', $customer->id) }}" method="POST" class="delete-form" style="display:inline">
                        @csrf @method('DELETE')
                        <button type="button" class="btn btn-danger btn-sm delete-btn" data-message="Are you sure you want to delete this customer?">Delete</button>
                    </form>
                    @endcan
                </td>
                @endcanany
            </tr>
            @endforeach
        </tbody>
    </table>

    {{ $items->links('pagination::bootstrap-5') }}

    @include('partials.delete-modal')
</div>
@endsection
