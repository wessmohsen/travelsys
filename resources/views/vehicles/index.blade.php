@extends('layouts.app')
@section('content')
<div class="container-fluid">
    <h1>Vehicles</h1>
    <a href="{{ route('vehicles.create') }}" class="btn btn-success mb-3">+ Add Vehicle</a>
    <table class="table table-bordered">
        <thead><tr><th>ID</th><th>Plate Number</th><th>Type</th><th>Actions</th></tr></thead>
        <tbody>
        @foreach($items as $item)
            <tr>
                <td>{{ $item->id }}</td>
                <td>{{ $item->plate_number }}</td>
                <td>{{ $item->type }}</td>
                <td>
                    <a href="{{ route('vehicles.edit',$item->id) }}" class="btn btn-sm btn-primary">Edit</a>
                    <form method="POST" action="{{ route('vehicles.destroy',$item->id) }}" style="display:inline-block;">
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
