@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <h1>Roles</h1>
    @include('partials.breadcrumbs')
    @include('partials.flash')

    <a href="{{ route('roles.create') }}" class="btn btn-success mb-3">+ Add Role</a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Description</th>
                <th>Users Count</th>
                <th>Permissions Count</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($items as $role)
            <tr>
                <td>{{ $role->id }}</td>
                <td><strong>{{ $role->name }}</strong></td>
                <td>{{ $role->description ?? '-' }}</td>
                <td>{{ $role->users_count }}</td>
                <td>{{ $role->permissions_count }}</td>
                <td>
                    <a href="{{ route('roles.edit', $role->id) }}" class="btn btn-primary btn-sm">Edit</a>
                    <form action="{{ route('roles.destroy', $role->id) }}" method="POST" class="delete-form" style="display:inline">
                        @csrf @method('DELETE')
                        <button type="button" class="btn btn-danger btn-sm delete-btn" data-message="Are you sure you want to delete this role?">Delete</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="text-center">No roles found</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    {{ $items->links('pagination::bootstrap-5') }}

    @include('partials.delete-modal')
</div>
@endsection
