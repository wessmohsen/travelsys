@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <h1>Edit Customer: {{ $item->name }}</h1>
        @include('partials.flash')
        @include('partials.breadcrumbs')

        <form method="POST" action="{{ route('customers.update', $item->id) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="card">
                <div class="card-header p-2">
                    <ul class="nav nav-pills" id="customerTabs" role="tablist">
                        <li class="nav-item"><button class="nav-link active" id="tab-personal" data-bs-toggle="tab" data-bs-target="#personal" type="button">Personal Data</button></li>
                        <li class="nav-item"><button class="nav-link" id="tab-passport" data-bs-toggle="tab" data-bs-target="#passport" type="button">Passport</button></li>
                        <li class="nav-item"><button class="nav-link" id="tab-dive" data-bs-toggle="tab" data-bs-target="#dive" type="button">Dive Center</button></li>
                        <li class="nav-item"><button class="nav-link" id="tab-accommodation" data-bs-toggle="tab" data-bs-target="#accommodation" type="button">Accommodation</button></li>
                        <li class="nav-item"><button class="nav-link" id="tab-contact" data-bs-toggle="tab" data-bs-target="#contact" type="button">Contact & Address</button></li>
                        <li class="nav-item"><button class="nav-link" id="tab-extra" data-bs-toggle="tab" data-bs-target="#extra" type="button">Extra Info</button></li>

                        @if($item->customer_type === 'family')
                            <li class="nav-item" id="family-tab-item">
                                <button class="nav-link" id="tab-sub" data-bs-toggle="tab" data-bs-target="#sub" type="button">
                                    Family Members
                                </button>
                            </li>
                        @endif
                    </ul>
                </div>

                <div class="card-body">
                    <div class="tab-content">

                        <!-- PERSONAL -->
                        <div class="tab-pane fade show active" id="personal">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label>First Name</label>
                                    <input type="text" name="first_name" value="{{ old('first_name', $item->first_name) }}" class="form-control" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label>Last Name</label>
                                    <input type="text" name="last_name" value="{{ old('last_name', $item->last_name) }}" class="form-control" required>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label>Email <span class="text-danger">*</span></label>
                                    <input type="email" name="email" value="{{ old('email', $item->email) }}" class="form-control" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label>Phone</label>
                                    <input type="text" name="phone" value="{{ old('phone', $item->phone) }}" class="form-control">
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label>Date of Birth</label>
                                    <input type="date" name="dob" value="{{ old('dob', $item->dob) }}" class="form-control">
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label>Gender</label>
                                    <select name="gender" class="form-control">
                                        <option value="">Select</option>
                                        <option value="male" {{ $item->gender == 'male' ? 'selected' : '' }}>Male</option>
                                        <option value="female" {{ $item->gender == 'female' ? 'selected' : '' }}>Female</option>
                                    </select>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label>Vegetarian</label>
                                    <select name="vegetarian" class="form-control">
                                        <option value="0" {{ !$item->vegetarian ? 'selected' : '' }}>No</option>
                                        <option value="1" {{ $item->vegetarian ? 'selected' : '' }}>Yes</option>
                                    </select>
                                </div>

                                <!-- ✅ Customer Type -->
                                <div class="col-md-6 mb-3">
                                    <label>Customer Type</label>
                                    <select name="type" class="form-control">
                                        <option value="individual" {{ $item->customer_type == 'individual' ? 'selected' : '' }}>Individual</option>
                                        <option value="family" {{ $item->customer_type == 'family' ? 'selected' : '' }}>Family</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- PASSPORT -->
                        <div class="tab-pane fade" id="passport">
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label>Passport Number</label>
                                    <input type="text" name="passport_number" value="{{ old('passport_number', $item->passport_number) }}" class="form-control">
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label>Nationality</label>
                                    <input type="text" name="passport_nationality" value="{{ old('passport_nationality', $item->passport_nationality) }}" class="form-control">
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label>Valid Until</label>
                                    <input type="date" name="passport_valid_until" value="{{ old('passport_valid_until', $item->passport_valid_until) }}" class="form-control">
                                </div>
                            </div>
                        </div>

                        <!-- DIVE -->
                        <div class="tab-pane fade" id="dive">
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label>Check-in</label>
                                    <input type="date" name="dive_center_checkin" value="{{ old('dive_center_checkin', $item->dive_center_checkin) }}" class="form-control">
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label>Check-out</label>
                                    <input type="date" name="dive_center_checkout" value="{{ old('dive_center_checkout', $item->dive_center_checkout) }}" class="form-control">
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label>Next Flight Date</label>
                                    <input type="date" name="next_flight_date" value="{{ old('next_flight_date', $item->next_flight_date) }}" class="form-control">
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
                                            <option value="{{ $hotel->id }}" {{ $item->hotel_id == $hotel->id ? 'selected' : '' }}>
                                                {{ $hotel->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label>Room Number</label>
                                    <input type="text" name="room_number" value="{{ old('room_number', $item->room_number) }}" class="form-control">
                                </div>
                            </div>
                        </div>

                        <!-- CONTACT -->
                        <div class="tab-pane fade" id="contact">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label>Address</label>
                                    <input type="text" name="address" value="{{ old('address', $item->address) }}" class="form-control">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label>City</label>
                                    <input type="text" name="city" value="{{ old('city', $item->city) }}" class="form-control">
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label>State</label>
                                    <input type="text" name="state" value="{{ old('state', $item->state) }}" class="form-control">
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label>Zipcode</label>
                                    <input type="text" name="zipcode" value="{{ old('zipcode', $item->zipcode) }}" class="form-control">
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label>Country</label>
                                    <input type="text" name="country" value="{{ old('country', $item->country) }}" class="form-control">
                                </div>
                            </div>
                        </div>

                        <!-- EXTRA -->
                        <div class="tab-pane fade" id="extra">
                            <div class="mb-3">
                                <label>Languages</label>
                                <input type="text" name="languages" value="{{ old('languages', $item->languages) }}" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label>Additional Info</label>
                                <textarea name="additional_info" class="form-control" rows="3">{{ old('additional_info', $item->additional_info) }}</textarea>
                            </div>
                        </div>

                        @if($item->customer_type === 'family')
                            <!-- ✅ FAMILY MEMBERS -->
                            <div class="tab-pane fade" id="sub">
                                <input type="hidden" name="families[{{ $i }}][id]" value="{{ $fam['id'] ?? '' }}">
                                @include('customers.partials.subcustomers')
                            </div>
                        @endif

                    </div>
                </div>
            </div>

            <button class="btn btn-success mt-3">Update Customer</button>
        </form>
    </div>
@endsection

@section('scripts')
    <script>
        jQuery(document).ready(function () {

            // ✅ Reset and initialize select2
            jQuery('.select2').each(function () {
                if (jQuery(this).hasClass('select2-hidden-accessible')) {
                    jQuery(this).select2('destroy');
                }
            });

            jQuery('.select2').select2({
                width: '100%',
                placeholder: 'Select Hotel',
                allowClear: true,
                dropdownParent: jQuery('.card-body')
            });

            // ✅ Toggle Family Tab based on type
            function toggleFamilyTab() {
                var type = jQuery('select[name="type"]').val();
                var familyTab = jQuery('#family-tab-item');
                var familyContent = jQuery('#sub');

                if (type === 'family') {
                    familyTab.show();
                } else {
                    familyTab.hide();
                    if (familyContent.hasClass('show active')) {
                        jQuery('#customerTabs button:first').tab('show');
                    }
                }
            }

            // ✅ Call toggleFamilyTab on page load to reflect saved value
            toggleFamilyTab();

            // ✅ Handle Customer Type change with confirmation
            jQuery('select[name="type"]').on('change', function () {
                var newType = jQuery(this).val();
                var oldType = "{{ $item->customer_type }}"; // Get the original type from the server

                if (oldType === 'family' && newType === 'individual') {
                    if (confirm('Changing the customer type to "Individual" will delete all associated sub-customers. Do you want to proceed?')) {
                        // Send AJAX request to delete sub-customers
                        jQuery.ajax({
                            url: "{{ route('customers.subcustomers.delete', $item->id) }}", // Define this route in your backend
                            method: 'DELETE',
                            data: {
                                _token: "{{ csrf_token() }}"
                            },
                            success: function (response) {
                                alert('Sub-customers deleted successfully.');
                                toggleFamilyTab(); // Update the UI
                            },
                            error: function (xhr) {
                                alert('An error occurred while deleting sub-customers.');
                                // Revert the dropdown value to 'family'
                                jQuery('select[name="type"]').val('family').trigger('change');
                            }
                        });
                    } else {
                        // Revert the dropdown value to 'family'
                        jQuery('select[name="type"]').val('family').trigger('change');
                    }
                } else {
                    toggleFamilyTab();
                }
            });

            // Handle Delete Row button click (use event delegation for dynamically added rows)
            jQuery(document).on('click', '.delete-family', function () {
                const $btn = jQuery(this);
                const $row = $btn.closest('tr');
                const familyId = $btn.data('id');

                console.log('Delete button clicked', { familyId }); // Debugging: Ensure the event is triggered

                if (familyId) {
                    if (confirm('Are you sure you want to delete this family?')) {
                        jQuery.ajax({
                            url: `/program-families/${familyId}`,
                            type: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            success: function (response) {
                                console.log('Family deleted successfully', response); // Debugging: Ensure the AJAX request is successful
                                $row.fadeOut(300, function () {
                                    jQuery(this).remove();
                                });
                            },
                            error: function (xhr) {
                                console.error('Error deleting family', xhr); // Debugging: Log the error
                                alert('Failed to delete family. Please try again.');
                            }
                        });
                    }
                } else {
                    // If no `data-id`, simply remove the row
                    if (jQuery('#families-table tbody tr').length > 1) {
                        $row.remove();
                    } else {
                        alert('At least one row is required.');
                    }
                }
            });
        });
    </script>
@endsection
