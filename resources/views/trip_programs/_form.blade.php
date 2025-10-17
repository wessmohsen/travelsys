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

    <div class="table-responsive-wrapper">
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

@push('styles')
    <style>
        /* Enhanced table container with horizontal scroll */
        .table-responsive-wrapper {
            overflow-x: auto;
            overflow-y: visible;
            max-width: 100%;
            margin: 0 -15px;
            padding: 0 15px;
            border: 1px solid #e0e0e0;
            border-radius: 6px;
            background: #fff;
        }

        /* Enhanced table styling */
        #families-table {
            width: 100%;
            margin-bottom: 0;
            border-collapse: separate;
            border-spacing: 0;
            font-size: 13px;
            min-width: 2000px; /* Ensures horizontal scroll on smaller screens */
        }

        /* Sticky header */
        #families-table thead {
            position: sticky;
            top: 0;
            z-index: 10;
            background: linear-gradient(to bottom, #f8f9fa 0%, #e9ecef 100%);
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        #families-table thead th {
            background: linear-gradient(to bottom, #f8f9fa 0%, #e9ecef 100%);
            font-weight: 600;
            color: #2c3e50;
            padding: 12px 8px;
            border: 1px solid #dee2e6;
            text-align: center;
            white-space: nowrap;
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        /* Zebra striping for better readability */
        #families-table tbody tr:nth-child(odd) {
            background-color: #ffffff;
        }

        #families-table tbody tr:nth-child(even) {
            background-color: #f8f9fa;
        }

        /* Hover effect */
        #families-table tbody tr:hover {
            background-color: #e3f2fd !important;
            transition: background-color 0.2s ease;
        }

        /* Table cell styling */
        #families-table tbody td {
            padding: 8px 6px;
            border: 1px solid #dee2e6;
            vertical-align: middle;
        }

        /* Input and select styling within table */
        #families-table input[type="text"],
        #families-table input[type="number"],
        #families-table input[type="time"],
        #families-table select {
            padding: 6px 8px;
            border: 1px solid #ced4da;
            border-radius: 4px;
            font-size: 13px;
            width: 100%;
            box-sizing: border-box;
            transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
        }

        #families-table input[type="text"]:focus,
        #families-table input[type="number"]:focus,
        #families-table input[type="time"]:focus,
        #families-table select:focus {
            border-color: #80bdff;
            outline: 0;
            box-shadow: 0 0 0 0.2rem rgba(0,123,255,.25);
        }

        /* Customer select styling */
        .customer-select {
            min-width: 180px;
        }

        /* Remove row button styling */
        #families-table .remove-row {
            padding: 6px 12px;
            font-size: 14px;
            font-weight: bold;
            background-color: #dc3545;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.2s ease;
        }

        #families-table .remove-row:hover {
            background-color: #c82333;
            box-shadow: 0 2px 4px rgba(0,0,0,0.2);
        }

        /* Column-specific widths for better layout */
        #families-table th:nth-child(1),
        #families-table td:nth-child(1) { min-width: 200px; } /* Customer/Group */

        #families-table th:nth-child(2),
        #families-table td:nth-child(2) { min-width: 160px; } /* Agency */

        #families-table th:nth-child(3),
        #families-table th:nth-child(4),
        #families-table th:nth-child(5),
        #families-table td:nth-child(3),
        #families-table td:nth-child(4),
        #families-table td:nth-child(5) { min-width: 80px; text-align: center; } /* Adults, Children, Infants */

        #families-table th:nth-child(6),
        #families-table td:nth-child(6) { min-width: 160px; } /* Hotel */

        #families-table th:nth-child(7),
        #families-table td:nth-child(7) { min-width: 120px; } /* Room Number */

        #families-table th:nth-child(8),
        #families-table td:nth-child(8) { min-width: 130px; } /* Pickup Time */

        #families-table th:nth-child(9),
        #families-table td:nth-child(9) { min-width: 110px; } /* Activity */

        #families-table th:nth-child(10),
        #families-table td:nth-child(10) { min-width: 100px; } /* Size */

        #families-table th:nth-child(11),
        #families-table td:nth-child(11) { min-width: 130px; } /* Nationality */

        #families-table th:nth-child(12),
        #families-table td:nth-child(12) { min-width: 130px; } /* Boat */

        #families-table th:nth-child(13),
        #families-table td:nth-child(13) { min-width: 160px; } /* Guide */

        #families-table th:nth-child(14),
        #families-table td:nth-child(14) { min-width: 200px; } /* Transfer Contract */

        #families-table th:nth-child(15),
        #families-table th:nth-child(16),
        #families-table th:nth-child(17),
        #families-table td:nth-child(15),
        #families-table td:nth-child(16),
        #families-table td:nth-child(17) { min-width: 110px; text-align: right; } /* Collections */

        #families-table th:nth-child(18),
        #families-table td:nth-child(18) { min-width: 150px; } /* Remarks */

        #families-table th:nth-child(19),
        #families-table td:nth-child(19) { min-width: 80px; text-align: center; } /* Actions */

        /* Muted text styling */
        .muted {
            color: #6c757d;
            font-size: 11px;
            margin: 4px 0;
        }

        /* Add Family/Group button enhancement */
        #add-family-row {
            padding: 10px 20px;
            font-weight: 600;
            font-size: 14px;
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            transition: all 0.2s ease;
        }

        #add-family-row:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.15);
        }

        /* Responsive adjustments */
        @media screen and (max-width: 1400px) {
            .table-responsive-wrapper {
                margin: 0;
            }
        }

        /* Scroll hint shadow */
        .table-responsive-wrapper::after {
            content: '';
            position: absolute;
            top: 0;
            right: 0;
            bottom: 0;
            width: 30px;
            background: linear-gradient(to left, rgba(0,0,0,0.05), transparent);
            pointer-events: none;
        }
    </style>
@endpush

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
