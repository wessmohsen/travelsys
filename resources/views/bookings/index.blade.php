@extends('layouts.app')
@section('content')
<div class="container-fluid">
    <h1>Bookings</h1>

    @can('create-bookings')
    <a href="{{ route('bookings.create') }}" class="btn btn-success mb-3">+ Add Booking</a>
    @endcan

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Customer</th>
                <th>Trip</th>
                <th>Date</th>
                <th>Status</th>
                <th>Price</th>
                @canany(['edit-bookings', 'delete-bookings'])
                <th>Actions</th>
                @endcanany
            </tr>
        </thead>
        <tbody>
        @foreach($items as $item)
            <tr>
                <td>{{ $item->id }}</td>
                <td>{{ $item->customer ? $item->customer->name : '-' }}</td>
                <td>{{ $item->trip->name ?? '-' }}</td>
                <td>{{ $item->date }}</td>
                <td>{{ ucfirst($item->status) }}</td>
                <td>{{ $item->price }}</td>
                @canany(['edit-bookings', 'delete-bookings'])
                <td>
                    @can('edit-bookings')
                    <a href="{{ route('bookings.edit',$item->id) }}" class="btn btn-sm btn-primary">Edit</a>
                    @endcan

                    @can('delete-bookings')
                    <form method="POST" action="{{ route('bookings.destroy',$item->id) }}" class="delete-form" style="display:inline-block;">
                        @csrf @method('DELETE')
                        <button type="button" class="btn btn-sm btn-danger delete-btn" data-message="Are you sure you want to delete this booking?">Delete</button>
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
