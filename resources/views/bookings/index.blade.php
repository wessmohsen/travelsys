@extends('layouts.app')
@section('content')
<div class="container-fluid">
    <h1>Bookings</h1>
    <a href="{{ route('bookings.create') }}" class="btn btn-success mb-3">+ Add Booking</a>
    <table class="table table-bordered">
        <thead><tr><th>ID</th><th>Customer</th><th>Trip</th><th>Date</th><th>Status</th><th>Price</th><th>Actions</th></tr></thead>
        <tbody>
        @foreach($items as $item)
            <tr>
                <td>{{ $item->id }}</td>
                <td>{{ $item->customer ? $item->customer->name : '-' }}</td>
                <td>{{ $item->trip->name ?? '-' }}</td>
                <td>{{ $item->date }}</td>
                <td>{{ ucfirst($item->status) }}</td>
                <td>{{ $item->price }}</td>
                <td>
                    <a href="{{ route('bookings.edit',$item->id) }}" class="btn btn-sm btn-primary">Edit</a>
                    <form method="POST" action="{{ route('bookings.destroy',$item->id) }}" style="display:inline-block;">
                        @csrf @method('DELETE')
                        <button class="btn btn-sm btn-danger">Delete</button>
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    {{ $items->links('pagination::bootstrap-5') }}
</div>
@endsection
