@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <h1>Family Members of {{ $customer->first_name }} {{ $customer->last_name }}</h1>
    @include('partials.flash')

    <a href="{{ route('customers.subcustomers.create', $customer->id) }}" class="btn btn-primary mb-3">
        Add Family Member
    </a>

    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>#</th>
                <th>Relation</th>
                <th>Name</th>
                <th>Email</th>
                <th>Hotel</th>
                <th>Room</th>
                <th>Responsible</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($items as $item)
                <tr>
                    <td>{{ $item->id }}</td>
                    <td>{{ ucfirst($item->relation_type) }}</td>
                    <td>{{ $item->first_name }} {{ $item->last_name }}</td>
                    <td>{{ $item->email ?? '-' }}</td>
                    <td>{{ $item->hotel->name ?? '-' }}</td>
                    <td>{{ $item->room_number ?? '-' }}</td>
                    <td>{{ $item->responsible_name ?? '-' }}</td>
                    <td>
                        <a href="{{ route('customers.subcustomers.edit', [$customer->id, $item->id]) }}" class="btn btn-sm btn-warning">Edit</a>
                        <form action="{{ route('customers.subcustomers.destroy', [$customer->id, $item->id]) }}" method="POST" style="display:inline-block;">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-danger" onclick="return confirm('Delete this family member?')">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{ $items->links() }}
</div>
@endsection
