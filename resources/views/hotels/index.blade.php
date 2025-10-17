@extends('layouts.app')
@section('content')
<div class="container-fluid">
    <h1>Hotels</h1>

    @hasanyrole('admin', 'manager', 'operation-manager')
    <a href="{{ route('hotels.create') }}" class="btn btn-success mb-3">+ Add Hotel</a>
    @endhasanyrole

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Phone</th>
                <th>Website</th>
                <th>Status</th>
                <th>Location Order</th>
                @hasanyrole('admin', 'manager', 'operation-manager')
                <th>Actions</th>
                @endhasanyrole
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
                @hasanyrole('admin', 'manager', 'operation-manager')
                <td>
                    <a href="{{ route('hotels.edit',$item->id) }}" class="btn btn-sm btn-primary">Edit</a>
                    <form method="POST" action="{{ route('hotels.destroy',$item->id) }}" class="delete-form" style="display:inline-block;">
                        @csrf @method('DELETE')
                        <button type="button" class="btn btn-sm btn-danger delete-btn" data-message="Are you sure you want to delete this hotel?">Delete</button>
                    </form>
                </td>
                @endhasanyrole
            </tr>
        @endforeach
        </tbody>
    </table>
    {{ $items->links() }}

    @include('partials.delete-modal')
</div>
@endsection
