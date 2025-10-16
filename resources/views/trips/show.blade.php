@extends('layouts.app')
@section('content')
<div class="container-fluid">
    <h1>Trips</h1>
    <a href="{{ route('trips.create') }}" class="btn btn-success mb-3">+ Add Trip</a>
    <table class="table table-bordered">
        <thead><tr><th>ID</th><th>Name</th><th>Location</th><th>Date</th><th>Price</th><th>Description</th><th>Actions</th></tr></thead>
        <tbody>
        @foreach($items as $item)
            <tr>
                <td>{{ $item->id }}</td>
                <td>{{ $item->name }}</td>
                <td>{{ $item->location }}</td>
                <td>{{ $item->date }}</td>
                <td>{{ $item->price }}</td>
                <td>{{ $item->description ?? '-' }}</td>
                <td>
                    <a href="{{ route('trips.edit',$item->id) }}" class="btn btn-sm btn-primary">Edit</a>
                    <form method="POST" action="{{ route('trips.destroy',$item->id) }}" style="display:inline-block;">
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
