@extends('layouts.app')
@section('title','Daily Report')

@push('styles')
<style>
    .info-group {
        background: #f8f9fa;
        padding: 12px;
        border-radius: 4px;
    }
    .badge {
        display: inline-block;
        font-size: 0.875rem;
        line-height: 1;
    }
    .table-responsive {
        margin: 0 -1px; /* Prevent table shadow cutoff */
    }
    .table-responsive table {
        margin: 0;
    }
    table th, table td {
        white-space: nowrap;
    }
    /* Hover effect on table rows */
    table tbody tr:hover {
        background-color: #f8f9fa;
    }
    /* Currency columns alignment */
    .currency-column {
        text-align: right;
    }
    /* Status colors */
    .status-cell {
        display: inline-block;
        padding: 4px 8px;
        border-radius: 3px;
        font-size: 0.875rem;
    }
    .activity-status {
        display: inline-block;
        padding: 3px 6px;
        border-radius: 3px;
        font-size: 0.8125rem;
        font-weight: 500;
        text-transform: uppercase;
    }
    .activity-status.fun { background: #e3fcef; color: #0a6c3b; }
    .activity-status.snk { background: #fff4e5; color: #9a5b0c; }
    .activity-status.dp { background: #e8eaf6; color: #1a237e; }
    .activity-status.intro { background: #ffebee; color: #b71c1c; }

    /* Currency column styles */
    .currency-value {
        font-family: "SF Mono", SFMono-Regular, ui-monospace, Menlo, Consolas, monospace;
        text-align: right;
        padding-right: 16px !important;
        min-width: 100px;
    }

    /* Transfer info styling */
    .transfer-info {
        font-size: 0.9rem;
        line-height: 1.4;
    }
    .transfer-info .text-muted {
        color: #6c757d;
        font-size: 0.85rem;
    }

    /* Table cell padding and alignment */
    table td {
        padding: 12px;
        border-bottom: 1px solid #dee2e6;
    }
    .currency-column {
        font-family: monospace;
        text-align: right;
    }

    /* Tooltip styles for truncated text */
    [title] {
        cursor: help;
    }
</style>
@endpush

@section('content')
<div class="container-fluid">
    <h1>Daily Report — {{ $tripProgram->date ? $tripProgram->date->format('Y-m-d') : 'N/A' }}</h1>
    @include('partials.breadcrumbs', ['crumbs' => [
        ['href' => route('trip-programs.index'), 'text' => 'Trip Programs'],
        ['text' => 'View Daily Report']
    ]])

    <div class="card" style="margin-bottom: 0;">
        <div style="display:flex;gap:8px;flex-wrap:wrap;align-items:center;justify-content:space-between">
            <div style="display:flex;gap:8px;flex-wrap:wrap">
                <a class="btn" href="{{ route('trip-programs.index') }}" style="background:#f8f9fa;border-color:#ddd">&larr; Back</a>
            <a class="btn" href="{{ route('trip-programs.show', $tripProgram) }}?export=pdf" style="background:#4CAF50;color:white">
                <i class="fas fa-file-pdf"></i> Export PDF
            </a>
            <a class="btn" href="{{ route('trip-programs.show', $tripProgram) }}?export=excel" style="background:#217346;color:white">
                <i class="fas fa-file-excel"></i> Export Excel
            </a>
        </div>
        @can('edit-trip-programs')
        <a class="btn" href="{{ route('trip-programs.edit',$tripProgram) }}" style="background:#007bff;color:white">
            <i class="fas fa-edit"></i> Edit
        </a>
        @endcan
    </div>
</div>

<div class="card" style="margin-top: 16px;">
    <div style="display:flex;justify-content:flex-end;margin-bottom:20px">
        <div style="text-align:right">
            <span class="badge" style="background:{{ $tripProgram->status === 'done' ? '#4CAF50' : ($tripProgram->status === 'confirmed' ? '#2196F3' : '#FFC107') }};color:white;padding:6px 12px;border-radius:4px;font-weight:500">
                {{ ucfirst($tripProgram->status) }}
            </span>
        </div>
    </div>

    <div style="display:grid;grid-template-columns:repeat(auto-fit, minmax(250px, 1fr));gap:20px;margin-bottom:20px">
        <div class="info-group">
            <label style="color:#666;font-size:0.9rem">Trip</label>
            <div style="font-size:1.1rem;font-weight:500">{{ $tripProgram->trip->name ?? '-' }}</div>
        </div>
        <div class="info-group">
            <label style="color:#666;font-size:0.9rem">Organizer</label>
            <div style="font-size:1.1rem;font-weight:500">{{ $tripProgram->organizer->name ?? 'N/A' }}</div>
        </div>
        <div class="info-group">
            <label style="color:#666;font-size:0.9rem">Last Modified</label>
            <div style="font-size:1.1rem">{{ $tripProgram->last_modified_at ? $tripProgram->last_modified_at->format('Y-m-d H:i') : 'N/A' }}</div>
        </div>
    </div>

    @if($tripProgram->remarks)
        <div style="background:#f8f9fa;padding:15px;border-radius:4px;margin-top:10px">
            <label style="color:#666;font-size:0.9rem;display:block;margin-bottom:4px">Remarks</label>
            <div style="color:#333">{{ $tripProgram->remarks }}</div>
        </div>
    @endif
</div>

<br>

<div class="card" style="margin-top:16px">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <h3 style="margin: 0;font-size:1.5rem">Families / Groups</h3>
        <div style="display:flex;align-items:center;gap:12px">
            <label style="display: flex; align-items: center; gap: 8px; cursor: pointer;">
                <input type="checkbox" id="toggleCustomerColumn" checked style="width:16px;height:16px">
                <span style="font-size:0.9rem;color:#444">Show Customer Column</span>
            </label>
        </div>
    </div>

    <div class="table-responsive" style="overflow-x:auto">
        <table style="border-collapse:separate;border-spacing:0;width:100%;background:white;border-radius:4px;box-shadow:0 1px 3px rgba(0,0,0,0.1)">
            <thead>
                <tr style="background:#f8f9fa">
                    <th class="customer-column" style="padding:12px;border-bottom:2px solid #dee2e6;font-weight:600">Customer / Group</th>
                    <th style="padding:12px;border-bottom:2px solid #dee2e6;font-weight:600">A</th>
                    <th style="padding:12px;border-bottom:2px solid #dee2e6;font-weight:600">C</th>
                    <th style="padding:12px;border-bottom:2px solid #dee2e6;font-weight:600">I</th>
                    <th style="padding:12px;border-bottom:2px solid #dee2e6;font-weight:600">Hotel</th>
                    <th style="padding:12px;border-bottom:2px solid #dee2e6;font-weight:600">Room</th>
                    <th style="padding:12px;border-bottom:2px solid #dee2e6;font-weight:600">Pickup</th>
                    <th style="padding:12px;border-bottom:2px solid #dee2e6;font-weight:600">Activity</th>
                    <th style="padding:12px;border-bottom:2px solid #dee2e6;font-weight:600">Size</th>
                    <th style="padding:12px;border-bottom:2px solid #dee2e6;font-weight:600">Nationality</th>
                    <th style="padding:12px;border-bottom:2px solid #dee2e6;font-weight:600">Boat Master</th>
                    <th style="padding:12px;border-bottom:2px solid #dee2e6;font-weight:600">Guide Name</th>
                    <th style="padding:12px;border-bottom:2px solid #dee2e6;font-weight:600">Agency</th>
                    <th style="padding:12px;border-bottom:2px solid #dee2e6;font-weight:600">Transfer Contract</th>
                    <th style="padding:12px;border-bottom:2px solid #dee2e6;font-weight:600;text-align:right;padding-right:16px">EGP</th>
                    <th style="padding:12px;border-bottom:2px solid #dee2e6;font-weight:600;text-align:right;padding-right:16px">USD</th>
                    <th style="padding:12px;border-bottom:2px solid #dee2e6;font-weight:600;text-align:right;padding-right:16px">EUR</th>
                    <th style="padding:12px;border-bottom:2px solid #dee2e6;font-weight:600">Remarks</th>
            </tr>
        </thead>
        <tbody>
        @foreach($tripProgram->families as $idx => $fam)
            <tr>
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
                <td style="text-align:center">{{ $fam->adults ?: '-' }}</td>
                <td style="text-align:center">{{ $fam->children ?: '-' }}</td>
                <td style="text-align:center">{{ $fam->infants ?: '-' }}</td>
                <td>
                    @if($fam->hotel)
                        <span title="{{ $fam->hotel->name }}">{{ $fam->hotel->name }}</span>
                    @else
                        -
                    @endif
                </td>
                <td>{{ $fam->room_number ?: '-' }}</td>
                <td>{{ $fam->pickup_time ?: '-' }}</td>
                <td><span class="activity-status {{ strtolower($fam->activity) }}">{{ $fam->activity ?: '-' }}</span></td>
                <td>{{ $fam->size ?: '-' }}</td>
                <td>{{ $fam->nationality ?: '-' }}</td>
                <td>{{ optional($fam->boat)->name ?? '-' }}</td>
                <td>{{ $fam->guide->name ?? '-' }}</td>
                <td>
                    @if($fam->agency)
                        <span title="{{ $fam->agency->name }}">{{ $fam->agency->name }}</span>
                    @else
                        -
                    @endif
                </td>
                <td>
                    @if($fam->transferContract && $fam->transferContract->driver)
                        <div class="transfer-info">
                            <div style="font-weight:500">{{ $fam->transferContract->driver->name }}</div>
                            @if($fam->transferContract->contract_type === 'company' && $fam->transferContract->company_name)
                                <div class="text-muted">{{ $fam->transferContract->company_name }}</div>
                            @endif
                            <div class="text-muted" style="font-size:0.8125rem">
                                {{ $fam->transferContract->driver->phone }}
                                @if($fam->transferContract->driver->alternative_phone)
                                    <br>{{ $fam->transferContract->driver->alternative_phone }}
                                @endif
                            </div>
                        </div>
                    @elseif($fam->transferContract)
                        <div class="transfer-info">
                            <div style="font-weight:500">{{ $fam->transferContract->company_name ?? 'No Driver' }}</div>
                            <div class="text-muted" style="font-size:0.8125rem">{{ $fam->transferContract->from }} → {{ $fam->transferContract->to }}</div>
                        </div>
                    @else
                        -
                    @endif
                </td>
                <td class="currency-value">{{ $fam->collect_egp !== null ? number_format($fam->collect_egp, 2) : '-' }}</td>
                <td class="currency-value">{{ $fam->collect_usd !== null ? number_format($fam->collect_usd, 2) : '-' }}</td>
                <td class="currency-value">{{ $fam->collect_eur !== null ? number_format($fam->collect_eur, 2) : '-' }}</td>
                <td>{{ $fam->remarks ?: '-' }}</td>
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
