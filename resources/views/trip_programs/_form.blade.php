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
                <th>Adults</th>
                <th>Children</th>
                <th>Infants</th>
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
        document.addEventListener('DOMContentLoaded', function () {
            if (typeof jQuery === 'undefined') {
                console.error('jQuery not loaded!');
                return;
            }

            jQuery(function () {
                var rowIndex = jQuery('#families-table tbody tr').length;

                // Add row
                jQuery('#add-family-row').on('click', function () {
                    rowIndex++;
                    var newRow = `
                            <tr>
                                <td><input type="text" name="families[${rowIndex}][group_name]" class="form-control" placeholder="Group Name"></td>
                                <td><input type="number" name="families[${rowIndex}][adults]" class="form-control" min="0" placeholder="Adults"></td>
                                <td><input type="number" name="families[${rowIndex}][children]" class="form-control" min="0" placeholder="Children"></td>
                                <td><input type="number" name="families[${rowIndex}][infants]" class="form-control" min="0" placeholder="Infants"></td>
                                <td><button type="button" class="btn btn-danger remove-row">X</button></td>
                            </tr>`;
                    jQuery('#families-table tbody').append(newRow);
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
