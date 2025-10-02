@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <h1>Customer: {{ $customer->name }}</h1>
    @include('partials.breadcrumbs')

    <div class="card">
        <div class="card-header p-2">
            <ul class="nav nav-pills" id="customerTabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="tab-personal" data-bs-toggle="tab" data-bs-target="#personal"
                        type="button" role="tab" aria-controls="personal" aria-selected="true">
                        Personal Data
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="tab-passport" data-bs-toggle="tab" data-bs-target="#passport"
                        type="button" role="tab" aria-controls="passport" aria-selected="false">
                        Passport
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="tab-dive" data-bs-toggle="tab" data-bs-target="#dive" type="button"
                        role="tab" aria-controls="dive" aria-selected="false">
                        Dive Center
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="tab-contact" data-bs-toggle="tab" data-bs-target="#contact"
                        type="button" role="tab" aria-controls="contact" aria-selected="false">
                        Contact & Address
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="tab-extra" data-bs-toggle="tab" data-bs-target="#extra" type="button"
                        role="tab" aria-controls="extra" aria-selected="false">
                        Extra Info
                    </button>
                </li>
            </ul>
        </div>

        <div class="card-body">
            <div class="tab-content" id="customerTabsContent">

                <!-- Personal Data -->
                <div class="tab-pane fade show active" id="personal" role="tabpanel" aria-labelledby="tab-personal">
                    <table class="table table-striped">
                        <tr>
                            <th>First Name</th>
                            <td>{{ $customer->first_name ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>Last Name</th>
                            <td>{{ $customer->last_name ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>Email</th>
                            <td>{{ $customer->email ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>Phone</th>
                            <td>{{ $customer->phone ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>Date of Birth</th>
                            <td>{{ $customer->dob ? \Carbon\Carbon::parse($customer->dob)->format('d M Y') : '-' }}</td>
                        </tr>
                        <tr>
                            <th>Gender</th>
                            <td>{{ ucfirst($customer->gender ?? '-') }}</td>
                        </tr>
                        <tr>
                            <th>Vegetarian</th>
                            <td>
                                @if($customer->vegetarian)
                                    <span class="badge bg-success">Yes</span>
                                @else
                                    <span class="badge bg-secondary">No</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>Languages</th>
                            <td>{{ $customer->languages ?? '-' }}</td>
                        </tr>
                    </table>
                </div>

                <!-- Passport -->
                <div class="tab-pane fade" id="passport" role="tabpanel" aria-labelledby="tab-passport">
                    <table class="table table-bordered">
                        <tr>
                            <th>Passport Number</th>
                            <td>{{ $customer->passport_number ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>Nationality</th>
                            <td>{{ $customer->passport_nationality ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>Valid Until</th>
                            <td>{{ $customer->passport_valid_until ? \Carbon\Carbon::parse($customer->passport_valid_until)->format('d M Y') : '-' }}</td>
                        </tr>
                    </table>
                </div>

                <!-- Dive Center -->
                <div class="tab-pane fade" id="dive" role="tabpanel" aria-labelledby="tab-dive">
                    <table class="table table-hover">
                        <tr>
                            <th>Check-in</th>
                            <td>{{ $customer->dive_center_checkin ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>Check-out</th>
                            <td>{{ $customer->dive_center_checkout ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>Next Flight</th>
                            <td>{{ $customer->next_flight_date ? \Carbon\Carbon::parse($customer->next_flight_date)->format('d M Y H:i') : '-' }}</td>
                        </tr>
                    </table>
                </div>

                <!-- Contact & Address -->
                <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="tab-contact">
                    <table class="table table-sm">
                        <tr>
                            <th>Address</th>
                            <td>{{ $customer->address ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>City</th>
                            <td>{{ $customer->city ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>State</th>
                            <td>{{ $customer->state ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>Zipcode</th>
                            <td>{{ $customer->zipcode ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>Country</th>
                            <td>{{ $customer->country ?? '-' }}</td>
                        </tr>
                    </table>
                </div>

                <!-- Extra Info -->
                <div class="tab-pane fade" id="extra" role="tabpanel" aria-labelledby="tab-extra">
                    <p>{{ $customer->additional_info ?? 'No extra info' }}</p>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection
