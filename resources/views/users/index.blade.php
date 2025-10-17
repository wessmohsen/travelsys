@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <h1>Users</h1>
    @include('partials.breadcrumbs')
    @include('partials.flash')

    <a href="{{ route('users.create') }}" class="btn btn-success mb-3">+ Add User</a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Created At</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($items as $user)
            <tr>
                <td>{{ $user->id }}</td>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->created_at->format('Y-m-d') }}</td>
                <td>
                    <a href="{{ route('users.edit', $user->id) }}" class="btn btn-primary btn-sm">Edit</a>
                    @if($user->id !== Auth::id())
                    <form action="{{ route('users.destroy', $user->id) }}" method="POST" class="delete-form" style="display:inline">
                        @csrf @method('DELETE')
                        <button type="button" class="btn btn-danger btn-sm delete-btn" data-message="Are you sure you want to delete this user?">Delete</button>
                    </form>
                    @endif
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="text-center">No users found</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    {{ $items->links('pagination::bootstrap-5') }}

    @include('partials.delete-modal')
</div>
@endsection
