@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <h1>Add New Customer</h1>
        @include('partials.flash')
        @include('partials.breadcrumbs')

        <form method="POST" action="{{ route('customers.store') }}" enctype="multipart/form-data">
            @csrf

            <div class="card">
                <div class="card-header p-2">
                    <ul class="nav nav-pills" id="customerTabs" role="tablist">
                        <li class="nav-item"><button class="nav-link active" id="tab-personal" data-bs-toggle="tab"
                                data-bs-target="#personal" type="button">Personal Data</button></li>
                        <li class="nav-item"><button class="nav-link" id="tab-passport" data-bs-toggle="tab"
                                data-bs-target="#passport" type="button">Passport</button></li>
                        <li class="nav-item"><button class="nav-link" id="tab-dive" data-bs-toggle="tab"
                                data-bs-target="#dive" type="button">Dive Center</button></li>
                        <li class="nav-item"><button class="nav-link" id="tab-accommodation" data-bs-toggle="tab"
                                data-bs-target="#accommodation" type="button">Accommodation</button></li>
                        <li class="nav-item"><button class="nav-link" id="tab-contact" data-bs-toggle="tab"
                                data-bs-target="#contact" type="button">Contact & Address</button></li>
                        <li class="nav-item"><button class="nav-link" id="tab-extra" data-bs-toggle="tab"
                                data-bs-target="#extra" type="button">Extra Info</button></li>
                    </ul>
                </div>

                <div class="card-body">
                    <div class="tab-content">

                        <!-- PERSONAL -->
                        <div class="tab-pane fade show active" id="personal">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label>First Name</label>
                                    <input type="text" name="first_name" value="{{ old('first_name') }}" class="form-control" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label>Last Name</label>
                                    <input type="text" name="last_name" value="{{ old('last_name') }}" class="form-control" required>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label>Email <span class="text-danger">*</span></label>
                                    <input type="email" name="email" value="{{ old('email') }}" class="form-control" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label>Phone</label>
                                    <input type="text" name="phone" value="{{ old('phone') }}" class="form-control">
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label>Date of Birth</label>
                                    <input type="date" name="dob" value="{{ old('dob') }}" class="form-control">
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label>Gender</label>
                                    <select name="gender" class="form-control">
                                        <option value="">Select</option>
                                        <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>Male</option>
                                        <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Female
                                        </option>
                                    </select>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label>Vegetarian</label>
                                    <select name="vegetarian" class="form-control">
                                        <option value="0" {{ old('vegetarian') == '0' ? 'selected' : '' }}>No</option>
                                        <option value="1" {{ old('vegetarian') == '1' ? 'selected' : '' }}>Yes</option>
                                    </select>
                                </div>

                                <!-- ✅ Customer Type تم نقله هنا -->
                                <div class="col-md-6 mb-3">
                                    <label>Customer Type</label>
                                    <select name="type" class="form-control">
                                        <option value="individual" {{ old('type') == 'individual' ? 'selected' : '' }}>
                                            Individual</option>
                                        <option value="family" {{ old('type') == 'family' ? 'selected' : '' }}>Family</option>
                                    </select>
                                </div>
                            </div>
                        </div>


                        <!-- PASSPORT -->
                        <div class="tab-pane fade" id="passport">
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label>Passport Number</label>
                                    <input type="text" name="passport_number" value="{{ old('passport_number') }}"
                                        class="form-control">
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label>Nationality</label>
                                    <input type="text" name="passport_nationality" value="{{ old('passport_nationality') }}"
                                        class="form-control">
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label>Valid Until</label>
                                    <input type="date" name="passport_valid_until" value="{{ old('passport_valid_until') }}"
                                        class="form-control">
                                </div>
                            </div>
                        </div>

                        <!-- DIVE -->
                        <div class="tab-pane fade" id="dive">
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label>Check-in</label>
                                    <input type="date" name="dive_center_checkin" value="{{ old('dive_center_checkin') }}"
                                        class="form-control">
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label>Check-out</label>
                                    <input type="date" name="dive_center_checkout" value="{{ old('dive_center_checkout') }}"
                                        class="form-control">
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label>Next Flight Date</label>
                                    <input type="date" name="next_flight_date" value="{{ old('next_flight_date') }}"
                                        class="form-control">
                                </div>
                            </div>
                        </div>

                        <!-- ACCOMMODATION -->
                        <div class="tab-pane fade" id="accommodation">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label>Hotel</label>
                                    <select name="hotel_id" class="form-select select2">
                                        <option value="">Select Hotel</option>
                                        @foreach($hotels as $hotel)
                                            <option value="{{ $hotel->id }}" {{ old('hotel_id') == $hotel->id ? 'selected' : '' }}>
                                                {{ $hotel->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label>Room Number</label>
                                    <input type="text" name="room_number" value="{{ old('room_number') }}"
                                        class="form-control">
                                </div>
                            </div>
                        </div>


                        <!-- CONTACT -->
                        <div class="tab-pane fade" id="contact">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label>Address</label>
                                    <input type="text" name="address" value="{{ old('address') }}" class="form-control">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label>City</label>
                                    <input type="text" name="city" value="{{ old('city') }}" class="form-control">
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label>State</label>
                                    <input type="text" name="state" value="{{ old('state') }}" class="form-control">
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label>Zipcode</label>
                                    <input type="text" name="zipcode" value="{{ old('zipcode') }}" class="form-control">
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label>Country</label>
                                    <input type="text" name="country" value="{{ old('country') }}" class="form-control">
                                </div>
                            </div>
                        </div>

                        <!-- EXTRA -->
                        <div class="tab-pane fade" id="extra">
                            <div class="mb-3">
                                <label>Languages</label>
                                <input type="text" name="languages" value="{{ old('languages') }}" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label>Additional Info</label>
                                <textarea name="additional_info" class="form-control"
                                    rows="3">{{ old('additional_info') }}</textarea>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <button class="btn btn-success mt-3">Save Customer</button>
        </form>
    </div>
@endsection


@section('scripts')
    {{-- Select2 CSS --}}
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <script>
        jQuery(document).ready(function () {
            // إعادة تهيئة Select2 لمنع التكرار
            jQuery('.select2').each(function () {
                if (jQuery(this).hasClass('select2-hidden-accessible')) {
                    jQuery(this).select2('destroy');
                }
            });

            // تفعيل select2
            jQuery('.select2').select2({
                width: '100%',
                placeholder: 'Select Hotel',
                allowClear: true,
                dropdownParent: jQuery('.card-body')
            });
        });
    </script>

    <style>
        .select2-container--default .select2-selection--single {
            height: 38px !important;
            border: 1px solid #ced4da !important;
            border-radius: 0.375rem !important;
            display: flex !important;
            align-items: center !important;
        }

        .select2-container--default .select2-selection__rendered {
            line-height: 38px !important;
        }

        .select2-container--default .select2-selection__arrow {
            height: 38px !important;
        }
    </style>
@endsection
        }
    </style>
@endsection
