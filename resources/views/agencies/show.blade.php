@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <h1>Agency: {{ $agency->name }}</h1>
    @include('partials.breadcrumbs')

    <div class="card">
        <div class="card-header p-2">
            <ul class="nav nav-pills" id="agencyTabs" role="tablist">
                <li class="nav-item">
                    <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#info" type="button">Company Information</button>
                </li>
                <li class="nav-item">
                    <button class="nav-link" data-bs-toggle="tab" data-bs-target="#address" type="button">Company Address</button>
                </li>
                <li class="nav-item">
                    <button class="nav-link" data-bs-toggle="tab" data-bs-target="#extra" type="button">Notes</button>
                </li>
            </ul>
        </div>

        <div class="card-body">
            <div class="tab-content">

                <!-- Info -->
                <div class="tab-pane fade show active" id="info">
                    <table class="table table-striped">
                        <tr><th>Email</th><td>{{ $agency->email ?? '-' }}</td></tr>
                        <tr><th>Phone</th><td>{{ $agency->phone ?? '-' }}</td></tr>
                        <tr><th>Tax Number</th><td>{{ $agency->tax_number ?? '-' }}</td></tr>
                        <tr><th>Partner</th><td>{{ $agency->is_partner ? 'Yes' : 'No' }}</td></tr>
                    </table>
                </div>

                <!-- Address -->
                <div class="tab-pane fade" id="address">
                    <table class="table table-bordered">
                        <tr><th>Street</th><td>{{ $agency->street ?? '-' }}</td></tr>
                        <tr><th>Number</th><td>{{ $agency->number ?? '-' }}</td></tr>
                        <tr><th>Zipcode</th><td>{{ $agency->zipcode ?? '-' }}</td></tr>
                        <tr><th>City</th><td>{{ $agency->city ?? '-' }}</td></tr>
                        <tr><th>State</th><td>{{ $agency->state ?? '-' }}</td></tr>
                        <tr><th>Country</th><td>{{ $agency->country ?? '-' }}</td></tr>
                    </table>
                </div>

                <!-- Notes -->
                <div class="tab-pane fade" id="extra">
                    <p>{{ $agency->notes ?? 'No notes' }}</p>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection
