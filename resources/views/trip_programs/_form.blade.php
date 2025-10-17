@php $editing = isset($program); @endphp

<div class="card">
    <h3>Section 1: Trip Info</h3>
    <div class="grid grid-3">
        <div>
            <label class="muted">Trip</label>
            <select name="trip_id" required>
                <option value="">-- Select Trip --</option>
                @foreach($trips as $t)
                    <option value="{{ $t->id }}" @selected(old('trip_id', $program->trip_id ?? '') == $t->id)>{{ $t->name }}
                    </option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="muted">Date</label>
            <input type="date" name="date" value="{{ old('date', optional($program->date ?? null)->format('Y-m-d')) }}"
                required>
        </div>
        <div>
            <label class="muted">Status</label>
            <select name="status">
                @foreach(['draft', 'confirmed', 'done'] as $st)
                    <option value="{{ $st }}" @selected(old('status', $program->status ?? 'draft') == $st)>{{ ucfirst($st) }}
                    </option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="muted">Organizer</label>
            <select name="organizer_id">
                <option value="">-- Select Organizer --</option>
                @foreach($organizers as $organizer)
                    <option value="{{ $organizer->id }}" @selected(old('organizer_id', $program->organizer_id ?? '') == $organizer->id)>{{ $organizer->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="grid-col-span-2">
            <label class="muted">Remarks</label>
            <textarea name="remarks" rows="2">{{ old('remarks', $program->remarks ?? '') }}</textarea>
        </div>
    </div>
</div>

<br>

<div class="card">
    <h3>Section 2: Families / Groups</h3>

    <div style="margin-bottom:10px">
        <button type="button" class="btn btn-primary" id="add-family-row">+ Add Family/Group</button>
    </div>

    <input type="hidden" name="deleted_families" id="deleted-families" value="">

    <div style="overflow-x: auto; margin: 0 -15px; padding: 0 15px;">
        <table id="families-table" class="table table-bordered" style="min-width: 100%;">
            <thead>
                <tr>
                    <th>Customer / Group Name</th>
                    <th>Agency</th>
                    <th>Adults</th>
                    <th>Children</th>
                    <th>Infants</th>
                    <th>Hotel</th>
                    <th>Room Number</th>
                    <th>Pickup Time</th>
                    <th>Activity</th>
                    <th>Size</th>
                    <th>Nationality</th>
                    <th>Boat</th>
                    <th>Guide</th>
                    <th>Transfer Contract</th>
                    <th>Collect (EGP)</th>
                    <th>Collect (USD)</th>
                    <th>Collect (EUR)</th>
                    <th>Remarks</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $rows = old('families', isset($program) ? $program->families->toArray() : []);
                @endphp

                @forelse($rows as $i => $fam)
                    @include('trip_programs._family_row', ['i' => $i, 'fam' => $fam])
                @empty
                    @include('trip_programs._family_row', ['i' => 0, 'fam' => []])
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            if (typeof jQuery === 'undefined') {
                console.error('jQuery not loaded!');
                return;
            }

            jQuery(function () {
                var rowIndex = jQuery('#families-table tbody tr').length;

                // Prepare dropdown options HTML
                var agencyOptions = `<option value="">-- Select Agency --</option>@foreach($agencies as $agency)<option value="{{ $agency->id }}">{{ $agency->name }}</option>@endforeach`;
                var hotelOptions = `<option value="">--</option>@foreach($hotels as $h)<option value="{{ $h->id }}">{{ $h->name }}</option>@endforeach`;
                var boatOptions = `<option value="">-- Select Boat --</option>@foreach($boats as $boat)<option value="{{ $boat->id }}">{{ $boat->name }}</option>@endforeach`;
                var guideOptions = `<option value="">-- Select Guide --</option>@foreach($guides as $guide)<option value="{{ $guide->id }}">{{ $guide->name }}</option>@endforeach`;
                var transferContractOptions = `<option value="">-- Select Contract --</option>@foreach($transferContracts as $contract)<option value="{{ $contract->id }}">@if($contract->driver){{ $contract->driver->name }}@if($contract->contract_type === 'company' && $contract->company_name) | {{ $contract->company_name }}@endif | {{ $contract->driver->phone }}@if($contract->driver->alternative_phone) | {{ $contract->driver->alternative_phone }}@endif @else{{ $contract->company_name ?? 'No Driver' }} ({{ $contract->from }} → {{ $contract->to }})@endif</option>@endforeach`;

                // Add row
                jQuery('#add-family-row').on('click', function () {
                    rowIndex++;
                    var newRow = `
                        <tr data-id="">
                            <input type="hidden" name="families[${rowIndex}][id]" value="">
                            <td>
                                <select class="customer-select" name="families[${rowIndex}][customer_id]">
                                </select>
                                <div class="muted" style="font-size:12px">or</div>
                                <input type="text" name="families[${rowIndex}][group_name]" placeholder="Group name (e.g., MASTER / ETS)">
                            </td>
                            <td>
                                <select name="families[${rowIndex}][agency_id]" style="min-width:150px">
                                    ${agencyOptions}
                                </select>
                            </td>
                            <td><input type="number" min="0" name="families[${rowIndex}][adults]" value="0" style="width:70px"></td>
                            <td><input type="number" min="0" name="families[${rowIndex}][children]" value="0" style="width:70px"></td>
                            <td><input type="number" min="0" name="families[${rowIndex}][infants]" value="0" style="width:70px"></td>
                            <td>
                                <select name="families[${rowIndex}][hotel_id]" style="min-width:150px">
                                    ${hotelOptions}
                                </select>
                            </td>
                            <td><input type="text" name="families[${rowIndex}][room_number]" value="" style="width:100px"></td>
                            <td><input type="time" name="families[${rowIndex}][pickup_time]" value="" style="width:120px"></td>
                            <td><input type="text" name="families[${rowIndex}][activity]" value="" style="width:100px" placeholder="SNK / DP / ..."></td>
                            <td><input type="text" name="families[${rowIndex}][size]" value="" style="width:90px"></td>
                            <td><input type="text" name="families[${rowIndex}][nationality]" value="" style="width:120px"></td>
                            <td>
                                <select name="families[${rowIndex}][boat_master]" style="width:120px">
                                    ${boatOptions}
                                </select>
                            </td>
                            <td>
                                <select name="families[${rowIndex}][guide_id]" style="min-width:150px">
                                    ${guideOptions}
                                </select>
                            </td>
                            <td>
                                <select name="families[${rowIndex}][transfer_contract_id]" style="min-width:150px">
                                    ${transferContractOptions}
                                </select>
                            </td>
                            <td><input type="number" step="0.01" min="0" name="families[${rowIndex}][collect_egp]" value="" style="width:100px"></td>
                            <td><input type="number" step="0.01" min="0" name="families[${rowIndex}][collect_usd]" value="" style="width:100px"></td>
                            <td><input type="number" step="0.01" min="0" name="families[${rowIndex}][collect_eur]" value="" style="width:100px"></td>
                            <td><input type="text" name="families[${rowIndex}][remarks]" value="" style="width:140px"></td>
                            <td>
                                <button type="button" class="btn btn-danger remove-row" data-id="">X</button>
                            </td>
                        </tr>`;
                    jQuery('#families-table tbody').append(newRow);

                    // Clean up trailing pipes in the newly added row
                    cleanTrailingPipes();
                });

                // Delete row (supports both classes just in case)
                // Handle Remove Row button click
                jQuery(document).on('click', '.remove-row', function () {
                    var $row = jQuery(this).closest('tr');
                    var deletedId = $row.data('id'); // from data-id="{{ $fam['id'] ?? '' }}"

                    var confirmDelete = confirm('Are you sure you want to remove this family/group?');
                    if (!confirmDelete) return;

                    // If this row represents an existing record, track it
                    if (deletedId) {
                        var current = jQuery('#deleted-families').val();
                        var updated = current ? current + ',' + deletedId : deletedId;
                        jQuery('#deleted-families').val(updated);
                    }

                    // Remove visually
                    if (jQuery('#families-table tbody tr').length > 1) {
                        $row.fadeOut(200, function () { jQuery(this).remove(); });
                    } else {
                        alert('At least one row is required.');
                    }
                });

                // Clean up trailing "|" in transfer contract dropdowns
                function cleanTrailingPipes() {
                    jQuery('select[name*="[transfer_contract_id]"] option').each(function() {
                        var text = jQuery(this).text();
                        // Remove trailing " | " or " |" at the end
                        text = text.replace(/\s*\|\s*$/g, '');
                        // Remove multiple consecutive " | " when there's nothing between them
                        text = text.replace(/(\s*\|\s*)+$/g, '');
                        jQuery(this).text(text);
                    });
                }

                // Run on page load
                cleanTrailingPipes();

                // Run after adding new rows
                jQuery('#add-family-row').on('click', function() {
                    setTimeout(cleanTrailingPipes, 100);
                });

            });
        });
    </script>
@endpush
