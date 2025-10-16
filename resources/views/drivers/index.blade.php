@extends('layouts.app')
@section('content')
<div class="container-fluid">
    <h1>Drivers</h1>
    <a href="{{ route('drivers.create') }}" class="btn btn-success mb-3">+ Add Driver</a>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Alt. Phone</th>
                <th>License Number</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        @foreach($items as $item)
            <tr>
                <td>{{ $item->id }}</td>
                <td>{{ $item->name }}</td>
                <td>{{ $item->email }}</td>
                <td>{{ $item->phone }}</td>
                <td>{{ $item->alternative_phone }}</td>
                <td>{{ $item->license_number }}</td>
                <td>
                    <a href="{{ route('drivers.edit',$item->id) }}" class="btn btn-sm btn-primary">Edit</a>
                    <form method="POST" action="{{ route('drivers.destroy',$item->id) }}" style="display:inline-block;">
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
