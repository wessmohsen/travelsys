@extends('layouts.app')
@section('title','Daily Report')

@section('content')
<div class="card">
    <div style="display:flex;gap:8px;flex-wrap:wrap">
        <a class="btn" href="{{ route('trip-programs.index') }}">&larr; Back</a>
        <a class="btn" href="{{ route('trip-programs.show', $tripProgram) }}?export=pdf">Export PDF</a>
        <a class="btn" href="{{ route('trip-programs.show', $tripProgram) }}?export=excel">Export Excel</a>

        @can('edit-trip-programs')
        <a class="btn" href="{{ route('trip-programs.edit',$tripProgram) }}">Edit</a>
        @endcan
    </div>
</div>

<br>

<div class="card">
    <h3 style="margin-top:0">Daily Report — {{ $tripProgram->date ? $tripProgram->date->format('Y-m-d') : 'N/A' }}</h3>
    <div class="grid grid-3" style="margin-bottom:10px">
        <div><strong>Trip:</strong> {{ $tripProgram->trip->name ?? '-' }}</div>
        <div><strong>Status:</strong> {{ ucfirst($tripProgram->status) }}</div>
    </div>

    <div class="grid grid-3" style="margin-top:10px">
        <div><strong>Organizer:</strong> {{ $tripProgram->organizer->name ?? 'N/A' }}</div>
        <div><strong>Last Modified:</strong> {{ $tripProgram->last_modified_at ? $tripProgram->last_modified_at->format('Y-m-d H:i') : 'N/A' }}</div>
    </div>

    @if($tripProgram->remarks)
        <div class="muted"><strong>Remarks:</strong> {{ $tripProgram->remarks }}</div>
    @endif
</div>

<br>

<div class="card">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px;">
        <h3 style="margin: 0;">Families / Groups (MARSA MU layout style)</h3>
        <label style="display: flex; align-items: center; gap: 5px; cursor: pointer;">
            <input type="checkbox" id="toggleCustomerColumn" checked>
            <span>Show Customer Column</span>
        </label>
    </div>
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th class="customer-column">Customer / Group</th>
                <th>A</th>
                <th>C</th>
                <th>I</th>
                <th>Hotel</th>
                <th>Room</th>
                <th>Pickup</th>
                <th>Activity</th>
                <th>Size</th>
                <th>Nationality</th>
                <th>Boat Master</th>
                <th>Guide Name</th>
                <th>Transfer Contract</th>
                <th>EGP</th>
                <th>USD</th>
                <th>EUR</th>
                <th>Remarks</th>
            </tr>
        </thead>
        <tbody>
        @foreach($tripProgram->families as $idx => $fam)
            <tr>
                <td>{{ $idx+1 }}</td>
                <td class="customer-column">
                    @php
                        $displayNames = [];

                        // Get customer names from customer_id array
                        if (!empty($fam->customer_id) && is_array($fam->customer_id)) {
                            $customers = \App\Models\Customer::whereIn('id', $fam->customer_id)->get();
                            foreach ($customers as $customer) {
                                $displayNames[] = $customer->name;
                            }
                        }

                        // Add group name if exists
                        if (!empty($fam->group_name)) {
                            $displayNames[] = $fam->group_name;
                        }

                        echo !empty($displayNames) ? implode(', ', $displayNames) : '-';
                    @endphp
                </td>
                <td>{{ $fam->adults }}</td>
                <td>{{ $fam->children }}</td>
                <td>{{ $fam->infants }}</td>
                <td>{{ $fam->hotel->name ?? '-' }}</td>
                <td>{{ $fam->room_number }}</td>
                <td>{{ $fam->pickup_time }}</td>
                <td>{{ $fam->activity }}</td>
                <td>{{ $fam->size }}</td>
                <td>{{ $fam->nationality }}</td>
                <td>{{ $fam->boat_master }}</td>
                <td>{{ $fam->guide_name }}</td>
                <td>
                    @if($fam->transferContract && $fam->transferContract->driver)
                        {{ $fam->transferContract->driver->name }}
                        @if($fam->transferContract->contract_type === 'company' && $fam->transferContract->company_name)
                            | {{ $fam->transferContract->company_name }}
                        @endif
                        | {{ $fam->transferContract->driver->phone }}
                        @if($fam->transferContract->driver->alternative_phone)
                            | {{ $fam->transferContract->driver->alternative_phone }}
                        @endif
                    @elseif($fam->transferContract)
                        {{ $fam->transferContract->company_name ?? 'No Driver' }} ({{ $fam->transferContract->from }} → {{ $fam->transferContract->to }})
                    @else
                        -
                    @endif
                </td>
                <td>{{ $fam->collect_egp !== null ? number_format($fam->collect_egp,2) : '' }}</td>
                <td>{{ $fam->collect_usd !== null ? number_format($fam->collect_usd,2) : '' }}</td>
                <td>{{ $fam->collect_eur !== null ? number_format($fam->collect_eur,2) : '' }}</td>
                <td>{{ $fam->remarks }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const checkbox = document.getElementById('toggleCustomerColumn');

    // Function to toggle columns - queries DOM each time
    function toggleColumns(show) {
        const customerColumns = document.querySelectorAll('.customer-column');
        customerColumns.forEach(function(col) {
            col.style.display = show ? '' : 'none';
        });
    }

    // Load saved preference from localStorage
    const savedState = localStorage.getItem('showCustomerColumn');
    if (savedState !== null) {
        checkbox.checked = savedState === 'true';
        toggleColumns(checkbox.checked);
    }

    checkbox.addEventListener('change', function() {
        toggleColumns(this.checked);
        // Save preference to localStorage
        localStorage.setItem('showCustomerColumn', this.checked);
    });
});
</script>

@endsection
