@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <h1>Edit Transfer Contract</h1>
        @include('partials.flash')

        <form action="{{ route('transfercontracts.update', $item->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label>Driver</label>
                <select name="driver_id" class="form-control">
                    <option value="">-- Select Driver --</option>
                    @foreach($drivers as $driver)
                        <option value="{{ $driver->id }}" {{ $item->driver_id == $driver->id ? 'selected' : '' }}>
                            {{ $driver->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label>Vehicle</label>
                <select name="vehicle_id" class="form-control">
                    <option value="">-- Select Vehicle --</option>
                    @foreach($vehicles as $vehicle)
                        <option value="{{ $vehicle->id }}" {{ $item->vehicle_id == $vehicle->id ? 'selected' : '' }}>
                            {{ $vehicle->plate_number }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label>Company</label>
                <input type="text" name="company_name" class="form-control"
                    value="{{ old('company_name', $item->company_name) }}">
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label>From</label>
                    <input type="text" name="from" class="form-control" value="{{ $item->from }}" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label>To</label>
                    <input type="text" name="to" class="form-control" value="{{ $item->to }}" required>
                </div>
            </div>

            <div class="mb-3">
                <label>Contract Type</label>
                <select name="contract_type" class="form-control" required>
                    <option value="driver" {{ $item->contract_type == 'driver' ? 'selected' : '' }}>Driver</option>
                    <option value="company" {{ $item->contract_type == 'company' ? 'selected' : '' }}>Company</option>
                </select>
            </div>

            <div class="mb-3">
                <label>Status</label>
                <select name="status" class="form-control" required>
                    <option value="active" {{ old('status', $item->status ?? '') == 'active' ? 'selected' : '' }}>Active</option>
                    <option value="inactive" {{ old('status', $item->status ?? '') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                </select>
            </div>

            <div class="mb-3">
                <input type="date" name="contract_date" class="form-control"
                    value="{{ old('contract_date', $item->contract_date) }}" required>
            </div>

            <button type="submit" class="btn btn-success">Update</button>
        </form>
    </div>
@endsection
