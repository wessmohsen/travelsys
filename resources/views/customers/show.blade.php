@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h1 class="mb-0">Customer: {{ $customer->name }}</h1>
            <a href="{{ route('customers.edit', $customer->id) }}" class="btn btn-primary">
                <i class="fa fa-edit me-1"></i> Edit Customer
            </a>
        </div>

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
                    @if($customer->customer_type === 'family')
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="tab-family" data-bs-toggle="tab" data-bs-target="#family" type="button"
                                role="tab" aria-controls="family" aria-selected="false">
                                Family Members
                            </button>
                        </li>
                    @endif
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
                            <tr>
                                <th>Hotel</th>
                                <td>{{ $customer->hotel->name ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>Room Number</th>
                                <td>{{ $customer->room_number ?? '-' }}</td>
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
                                <td>{{ $customer->passport_valid_until ? \Carbon\Carbon::parse($customer->passport_valid_until)->format('d M Y') : '-' }}
                                </td>
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
                                <td>{{ $customer->next_flight_date ? \Carbon\Carbon::parse($customer->next_flight_date)->format('d M Y H:i') : '-' }}
                                </td>
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

                    @if($customer->customer_type === 'family')
                        <!-- Family Members -->
                        <div class="tab-pane fade" id="family" role="tabpanel" aria-labelledby="tab-family">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h5>Family Members</h5>
                                <a href="{{ route('customers.subcustomers.create', $customer->id) }}"
                                    class="btn btn-primary btn-sm">Add Member</a>
                            </div>

                            @if($customer->subCustomers->count() > 0)
                                <table class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Relation</th>
                                            <th>Name</th>
                                            <th>Hotel</th>
                                            <th>Room</th>
                                            <th>Responsible</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($customer->subCustomers as $member)
                                            <tr>
                                                <td>{{ $member->id }}</td>
                                                <td>{{ ucfirst($member->relation_type) }}</td>
                                                <td>{{ $member->first_name }} {{ $member->last_name }}</td>
                                                <td>{{ $member->hotel->name ?? '-' }}</td>
                                                <td>{{ $member->room_number ?? '-' }}</td>
                                                <td>{{ $member->responsible_name ?? '-' }}</td>
                                                <td>
                                                    <a href="{{ route('customers.subcustomers.edit', [$customer->id, $member->id]) }}"
                                                        class="btn btn-sm btn-warning">Edit</a>
                                                    <form
                                                        action="{{ route('customers.subcustomers.destroy', [$customer->id, $member->id]) }}"
                                                        method="POST" style="display:inline-block;">
                                                        @csrf @method('DELETE')
                                                        <button class="btn btn-sm btn-danger"
                                                            onclick="return confirm('Delete this family member?')">Delete</button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            @else
                                <p class="text-muted">No family members added yet.</p>
                            @endif
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
@endsection
