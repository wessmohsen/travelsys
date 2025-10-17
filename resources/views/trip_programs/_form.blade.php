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

    <table id="families-table" class="table table-bordered">
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
                <th>Transfer Name</th>
                <th>Transfer Phone</th>
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

@push('scripts')
<script>
jQuery(function($) {
    let rowIndex = $('#families-table tbody tr').length;

    // Handle Add Family/Group button click
    $('#add-family-row').on('click', function() {
        rowIndex++;
        const newRow = `
            <tr data-id="">
                <input type="hidden" name="families[${rowIndex}][id]" value="">
                <td>
                    <select class="customer-select" name="families[${rowIndex}][customer_id]">
                        <option value="">-- Select Customer --</option>
                    </select>
                    <div class="muted" style="font-size:12px">or</div>
                    <input type="text" name="families[${rowIndex}][group_name]" class="form-control" placeholder="Group name (e.g., MASTER / ETS)">
                </td>
                <td>
                    <select name="families[${rowIndex}][agency_id]" style="min-width:150px">
                        <option value="">-- Select Agency --</option>
                        @foreach($agencies as $agency)
                            <option value="{{ $agency->id }}">{{ $agency->name }}</option>
                        @endforeach
                    </select>
                </td>
                <td><input type="number" min="0" name="families[${rowIndex}][adults]" class="form-control" style="width:70px" value="0"></td>
                <td><input type="number" min="0" name="families[${rowIndex}][children]" class="form-control" style="width:70px" value="0"></td>
                <td><input type="number" min="0" name="families[${rowIndex}][infants]" class="form-control" style="width:70px" value="0"></td>
                <td>
                    <select name="families[${rowIndex}][hotel_id]" style="min-width:150px">
                        <option value="">--</option>
                        @foreach($hotels as $h)
                            <option value="{{ $h->id }}">{{ $h->name }}</option>
                        @endforeach
                    </select>
                </td>
                <td><input type="text" name="families[${rowIndex}][room_number]" class="form-control" style="width:100px"></td>
                <td><input type="time" name="families[${rowIndex}][pickup_time]" class="form-control" style="width:120px"></td>
                <td><input type="text" name="families[${rowIndex}][activity]" class="form-control" style="width:100px" placeholder="SNK / DP / ..."></td>
                <td><input type="text" name="families[${rowIndex}][size]" class="form-control" style="width:90px"></td>
                <td><input type="text" name="families[${rowIndex}][nationality]" class="form-control" style="width:120px"></td>
                <td>
                    <select name="families[${rowIndex}][boat_master]" style="width:120px">
                        <option value="">-- Select Boat --</option>
                        @foreach($boats as $boat)
                            <option value="{{ $boat->id }}">{{ $boat->name }}</option>
                        @endforeach
                    </select>
                </td>
                <td>
                    <select name="families[${rowIndex}][guide_id]" style="min-width:150px">
                        <option value="">-- Select Guide --</option>
                        @foreach($guides as $guide)
                            <option value="{{ $guide->id }}">{{ $guide->name }}</option>
                        @endforeach
                    </select>
                </td>
                <td><input type="text" name="families[${rowIndex}][transfer_name]" class="form-control" style="width:120px"></td>
                <td><input type="text" name="families[${rowIndex}][transfer_phone]" class="form-control" style="width:120px"></td>
                <td><input type="number" step="0.01" min="0" name="families[${rowIndex}][collect_egp]" class="form-control" style="width:100px"></td>
                <td><input type="number" step="0.01" min="0" name="families[${rowIndex}][collect_usd]" class="form-control" style="width:100px"></td>
                <td><input type="number" step="0.01" min="0" name="families[${rowIndex}][collect_eur]" class="form-control" style="width:100px"></td>
                <td><input type="text" name="families[${rowIndex}][remarks]" class="form-control" style="width:140px"></td>
                <td>
                    <button type="button" class="btn btn-danger remove-row">X</button>
                </td>
            </tr>
        `;

        $('#families-table tbody').append(newRow);

        // Reinitialize select2 for new selects
        $('.customer-select').select2({
            width: '100%',
            placeholder: 'Search Customer...',
            allowClear: true,
            ajax: {
                url: '/api/customers/search',
                dataType: 'json',
                delay: 250,
                data: function(params) {
                    return { q: params.term };
                },
                processResults: function(data) {
                    return { results: data };
                }
            }
        });
    });

    // Handle Remove Row button click (use event delegation for dynamically added rows)
    $('#families-table').on('click', '.remove-row', function() {
        const $row = $(this).closest('tr');
        const familyId = $(this).data('id');

        // Add confirmation dialog
        if (!confirm('Are you sure you want to delete this row?')) {
            return; // Abort if user cancels
        }

        if (familyId) {
            $.ajax({
                url: `/program-families/${familyId}`,
                type: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                success: function(response) {
                    $row.fadeOut(300, function() {
                        $(this).remove();
                    });
                },
                error: function() {
                    alert('Failed to delete family. Please try again.');
                }
            });
        } else {
            // Remove the row directly for new rows
            $row.remove();
        }
    });
});
</script>
@endpush
