@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <h1>Transfer Contracts</h1>
    @include('partials.flash')

    <a href="{{ route('transfercontracts.create') }}" class="btn btn-primary mb-3">Add Contract</a>

    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Driver</th>
                <th>Vehicle</th>
                <th>Company</th>
                <th>From</th>
                <th>To</th>
                <th>Type</th>
                <th>Status</th>
                <th>Contract Date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($items as $item)
                <tr>
                    <td>{{ $item->id }}</td>
                    <td>{{ $item->driver->name ?? '-' }}</td>
                    <td>{{ $item->vehicle->plate_number ?? '-' }}</td>
                    <td>{{ $item->company_name ?? '-' }}</td>
                    <td>{{ $item->from }}</td>
                    <td>{{ $item->to }}</td>
                    <td>{{ ucfirst($item->contract_type) }}</td>
                    <td>
                        <span class="badge bg-{{ $item->status == 'active' ? 'success' : 'secondary' }}">
                            {{ ucfirst($item->status) }}
                        </span>
                    </td>
                    <td>{{ $item->contract_date }}</td>
                    <td>
                        <a href="{{ route('transfercontracts.show',$item->id) }}" class="btn btn-sm btn-info">Show</a>
                        <a href="{{ route('transfercontracts.edit',$item->id) }}" class="btn btn-sm btn-warning">Edit</a>
                        <form action="{{ route('transfercontracts.destroy',$item->id) }}" method="POST" style="display:inline-block;">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-danger" onclick="return confirm('Delete this contract?')">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{ $items->links() }}
</div>
@endsection
