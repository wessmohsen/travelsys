@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <h1>Edit Customer: {{ $item->name }}</h1>
    @include('partials.breadcrumbs')

    <form action="{{ route('customers.update', $item->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="card">
            <div class="card-header p-2">
                <ul class="nav nav-pills" id="customerEditTabs" role="tablist">
                    <li class="nav-item">
                        <button class="nav-link active" id="tab-personal" data-bs-toggle="tab" data-bs-target="#personal"
                            type="button" role="tab">Personal Data</button>
                    </li>
                    <li class="nav-item">
                        <button class="nav-link" id="tab-passport" data-bs-toggle="tab" data-bs-target="#passport"
                            type="button" role="tab">Passport</button>
                    </li>
                    <li class="nav-item">
                        <button class="nav-link" id="tab-dive" data-bs-toggle="tab" data-bs-target="#dive"
                            type="button" role="tab">Dive Center</button>
                    </li>
                    <li class="nav-item">
                        <button class="nav-link" id="tab-contact" data-bs-toggle="tab" data-bs-target="#contact"
                            type="button" role="tab">Contact & Address</button>
                    </li>
                    <li class="nav-item">
                        <button class="nav-link" id="tab-extra" data-bs-toggle="tab" data-bs-target="#extra"
                            type="button" role="tab">Extra Info</button>
                    </li>
                </ul>
            </div>

            <div class="card-body">
                <div class="tab-content">

                    <!-- Personal Data -->
                    <div class="tab-pane fade show active" id="personal" role="tabpanel">
                        <div class="mb-3">
                            <label>First Name</label>
                            <input type="text" name="first_name" value="{{ $item->first_name }}" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label>Last Name</label>
                            <input type="text" name="last_name" value="{{ $item->last_name }}" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label>Email</label>
                            <input type="email" name="email" value="{{ $item->email }}" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label>Phone</label>
                            <input type="text" name="phone" value="{{ $item->phone }}" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label>Date of Birth</label>
                            <input type="date" name="dob" value="{{ $item->dob }}" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label>Gender</label>
                            <select name="gender" class="form-control">
                                <option value="">-- Select --</option>
                                <option value="male" {{ $item->gender == 'male' ? 'selected' : '' }}>Male</option>
                                <option value="female" {{ $item->gender == 'female' ? 'selected' : '' }}>Female</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label>Vegetarian</label>
                            <select name="vegetarian" class="form-control">
                                <option value="0" {{ !$item->vegetarian ? 'selected' : '' }}>No</option>
                                <option value="1" {{ $item->vegetarian ? 'selected' : '' }}>Yes</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label>Languages</label>
                            <input type="text" name="languages" value="{{ $item->languages }}" class="form-control">
                        </div>
                    </div>

                    <!-- Passport -->
                    <div class="tab-pane fade" id="passport" role="tabpanel">
                        <div class="mb-3">
                            <label>Passport Number</label>
                            <input type="text" name="passport_number" value="{{ $item->passport_number }}" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label>Nationality</label>
                            <input type="text" name="passport_nationality" value="{{ $item->passport_nationality }}" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label>Valid Until</label>
                            <input type="date" name="passport_valid_until" value="{{ $item->passport_valid_until }}" class="form-control">
                        </div>
                    </div>

                    <!-- Dive Center -->
                    <div class="tab-pane fade" id="dive" role="tabpanel">
                        <div class="mb-3">
                            <label>Check-in</label>
                            <input type="date" name="dive_center_checkin" value="{{ $item->dive_center_checkin }}" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label>Check-out</label>
                            <input type="date" name="dive_center_checkout" value="{{ $item->dive_center_checkout }}" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label>Next Flight</label>
                            <input type="datetime-local" name="next_flight_date" value="{{ $item->next_flight_date }}" class="form-control">
                        </div>
                    </div>

                    <!-- Contact & Address -->
                    <div class="tab-pane fade" id="contact" role="tabpanel">
                        <div class="mb-3">
                            <label>Address</label>
                            <input type="text" name="address" value="{{ $item->address }}" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label>City</label>
                            <input type="text" name="city" value="{{ $item->city }}" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label>State</label>
                            <input type="text" name="state" value="{{ $item->state }}" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label>Zipcode</label>
                            <input type="text" name="zipcode" value="{{ $item->zipcode }}" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label>Country</label>
                            <input type="text" name="country" value="{{ $item->country }}" class="form-control">
                        </div>
                    </div>

                    <!-- Extra Info -->
                    <div class="tab-pane fade" id="extra" role="tabpanel">
                        <div class="mb-3">
                            <label>Additional Info</label>
                            <textarea name="additional_info" class="form-control">{{ $item->additional_info }}</textarea>
                        </div>
                    </div>

                </div>
            </div>

            <div class="card-footer">
                <button class="btn btn-primary">Update</button>
                <a href="{{ route('customers.index') }}" class="btn btn-secondary">Cancel</a>
            </div>
        </div>
    </form>
</div>
@endsection
