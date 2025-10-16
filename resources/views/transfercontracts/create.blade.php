@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <h1>Add Transfer Contract</h1>
        @include('partials.flash')

        <form action="{{ route('transfercontracts.store') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label>Contract Type</label>
                <select name="contract_type" id="contract_type" class="form-control" required>
                    <option value="driver">Driver</option>
                    <option value="company">Company</option>
                </select>
            </div>

            <div class="mb-3" id="company_name_field">
                <label>Company Name</label>
                <input type="text" name="company_name" id="company_name" class="form-control" value="{{ old('company_name') }}">
            </div>

            <div class="mb-3">
                <label>Driver</label>
                <select name="driver_id" class="form-control">
                    <option value="">-- Select Driver --</option>
                    @foreach($drivers as $driver)
                        <option value="{{ $driver->id }}">{{ $driver->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label>Vehicle</label>
                <select name="vehicle_id" class="form-control">
                    <option value="">-- Select Vehicle --</option>
                    @foreach($vehicles as $vehicle)
                        <option value="{{ $vehicle->id }}">{{ $vehicle->plate_number }}</option>
                    @endforeach
                </select>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label>From</label>
                    <input type="text" name="from" class="form-control" value="{{ old('from') }}" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label>To</label>
                    <input type="text" name="to" class="form-control" value="{{ old('to') }}" required>
                </div>
            </div>

            <div class="mb-3">
                <label>Status</label>
                <select name="status" class="form-control" required>
                    <option value="active">Active</option>
                    <option value="inactive">Inactive</option>
                </select>
            </div>

            <div class="mb-3">
                <label>Contract Date</label>
                <input type="date" name="contract_date" class="form-control" value="{{ old('contract_date') }}" required>
            </div>

            <button type="submit" class="btn btn-success">Save</button>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const contractType = document.getElementById('contract_type');
            const companyNameField = document.getElementById('company_name_field');
            const companyNameInput = document.getElementById('company_name');

            function toggleCompanyNameField() {
                if (contractType.value === 'driver') {
                    companyNameField.style.display = 'none';
                    companyNameInput.value = 'Not-Company';
                } else {
                    companyNameField.style.display = 'block';
                    companyNameInput.value = '';
                }
            }

            contractType.addEventListener('change', toggleCompanyNameField);
            toggleCompanyNameField(); // Initialize on page load
        });
    </script>
@endsection
