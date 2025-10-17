@extends('layouts.app')
@section('content')
<div class="container-fluid">
    <h1>Hotels</h1>
    <a href="{{ route('hotels.create') }}" class="btn btn-success mb-3">+ Add Hotel</a>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Phone</th>
                <th>Website</th>
                <th>Status</th>
                <th>Location Order</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        @foreach($items as $item)
            <tr>
                <td>{{ $item->id }}</td>
                <td>{{ $item->name }}</td>
                <td>{{ $item->phone }}</td>
                <td>{{ $item->website }}</td>
                <td>{{ ucfirst($item->status) }}</td>
                <td>{{ $item->location_ordering }}</td>
                <td>
                    <a href="{{ route('hotels.edit',$item->id) }}" class="btn btn-sm btn-primary">Edit</a>
                    <form method="POST" action="{{ route('hotels.destroy',$item->id) }}" style="display:inline-block;">
                        @csrf @method('DELETE')
                        <button class="btn btn-sm btn-danger">Delete</button>
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    {{ $items->links() }}
</div>
@endsection
