@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <h1>Transfer Contract Details</h1>

    <table class="table table-bordered">
        <tr>
            <th>Driver</th>
            <td>{{ $item->driver->name ?? '-' }}</td>
        </tr>
        <tr>
            <th>Vehicle</th>
            <td>{{ $item->vehicle->plate_number ?? '-' }}</td>
        </tr>
        <tr>
            <th>Company</th>
            <td>{{ $item->company_name ?? '-' }}</td>
        </tr>
        <tr>
            <th>From</th>
            <td>{{ $item->from }}</td>
        </tr>
        <tr>
            <th>To</th>
            <td>{{ $item->to }}</td>
        </tr>
        <tr>
            <th>Contract Type</th>
            <td>{{ ucfirst($item->contract_type) }}</td>
        </tr>
        <tr>
            <th>Status</th>
            <td>
                <span class="badge bg-{{ $item->status == 'active' ? 'success' : 'secondary' }}">
                    {{ ucfirst($item->status) }}
                </span>
            </td>
        </tr>
        <tr>
            <th>Contract Date</th>
            <td>{{ $item->contract_date }}</td>
        </tr>
    </table>

    <a href="{{ route('transfercontracts.index') }}" class="btn btn-secondary">Back</a>
</div>
@endsection
