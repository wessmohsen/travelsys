@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <h1>Permissions</h1>
    @include('partials.breadcrumbs')
    @include('partials.flash')

    @can('create-permissions')
    <a href="{{ route('permissions.create') }}" class="btn btn-success mb-3">+ Add Permission</a>
    @endcan

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Slug</th>
                <th>Description</th>
                <th>Roles Count</th>
                @canany(['edit-permissions', 'delete-permissions'])
                <th>Actions</th>
                @endcanany
            </tr>
        </thead>
        <tbody>
            @forelse($items as $permission)
            <tr>
                <td>{{ $permission->id }}</td>
                <td><strong>{{ $permission->name }}</strong></td>
                <td><code>{{ $permission->slug }}</code></td>
                <td>{{ $permission->description ?? '-' }}</td>
                <td>{{ $permission->roles_count }}</td>
                @canany(['edit-permissions', 'delete-permissions'])
                <td>
                    @can('edit-permissions')
                    <a href="{{ route('permissions.edit', $permission->id) }}" class="btn btn-primary btn-sm">Edit</a>
                    @endcan

                    @can('delete-permissions')
                    <form action="{{ route('permissions.destroy', $permission->id) }}" method="POST" class="delete-form" style="display:inline">
                        @csrf @method('DELETE')
                        <button type="button" class="btn btn-danger btn-sm delete-btn" data-message="Are you sure you want to delete this permission?">Delete</button>
                    </form>
                    @endcan
                </td>
                @endcanany
            </tr>
            @empty
            <tr>
                <td colspan="6" class="text-center">No permissions found</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    {{ $items->links('pagination::bootstrap-5') }}

    @include('partials.delete-modal')
</div>
@endsection
