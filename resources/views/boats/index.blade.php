@extends('layouts.app')
@section('content')
<div class="container-fluid">
    <h1>Boats</h1>
    <a href="{{ route('boats.create') }}" class="btn btn-success mb-3">+ Add Boat</a>
    <table class="table table-bordered">
        <thead><tr><th>ID</th><th>Name</th><th>Capacity</th><th>Actions</th></tr></thead>
        <tbody>
        @foreach($items as $item)
            <tr>
                <td>{{ $item->id }}</td>
                <td>{{ $item->name }}</td>
                <td>{{ $item->capacity }}</td>
                <td>
                    <a href="{{ route('boats.edit',$item->id) }}" class="btn btn-sm btn-primary">Edit</a>
                    <form method="POST" action="{{ route('boats.destroy',$item->id) }}" style="display:inline-block;">
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
