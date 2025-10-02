@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <h1>Agencies</h1>
    @include('partials.breadcrumbs')

    <a href="{{ route('agencies.create') }}" class="btn btn-success mb-3">+ Add Agency</a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Partner</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        @foreach($items as $item)
            <tr>
                <td>{{ $item->id }}</td>
                <td><a href="{{ route('agencies.show', $item->id) }}">{{ $item->name }}</a></td>
                <td>{{ $item->email ?? '-' }}</td>
                <td>{{ $item->phone ?? '-' }}</td>
                <td>{{ $item->is_partner ? 'Yes' : 'No' }}</td>
                <td>
                    <a href="{{ route('agencies.edit', $item->id) }}" class="btn btn-primary btn-sm">Edit</a>
                    <form action="{{ route('agencies.destroy', $item->id) }}" method="POST" class="d-inline">
                        @csrf @method('DELETE')
                        <button class="btn btn-danger btn-sm" onclick="return confirm('Delete this agency?')">Delete</button>
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

    {{ $items->links() }}
</div>
@endsection
