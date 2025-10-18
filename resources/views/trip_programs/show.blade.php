@extends('layouts.app')
@section('title','Daily Report')

@section('breadcrumbs')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('trip-programs.index') }}">Trip Programs</a></li>
            <li class="breadcrumb-item active">Daily Report</li>
        </ol>
    </nav>
@endsection

@push('styles')
<style>
    @if(isset($forPrint) && $forPrint)
    /* Print-specific styles */
    * {
        font-family: Arial, 'DejaVu Sans', sans-serif;
    }
    body {
        font-size: 12px;
        line-height: 1.3;
        margin: 0;
        padding: 10px;
    }
    .btn, .container-fluid > .card:first-child {
        display: none !important;
    }
    .card {
        border: none !important;
        margin: 0 !important;
        padding: 0 !important;
    }
    table {
        width: 100% !important;
        font-size: 10px !important;
        border-collapse: collapse !important;
    }
    table th, table td {
        border: 1px solid #ddd !important;
        padding: 4px !important;
    }
    @endif

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

    <form action="{{ route('trip-programs.show', $tripProgram) }}" method="GET" class="mb-4" id="filterForm">
        @csrf
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <div class="row">
            <div class="col-md-3">
                <div class="form-group">
                    <label for="boat_id">Filter by Boat</label>
                    <select name="boat_id" id="boat_id" class="form-control filter-select">
                        <option value="">All Boats</option>
                        @foreach($boats as $boat)
                            @php
                                $isSelected = (string)request('boat_id') === (string)$boat->id;
                                \Log::info('Boat Option:', [
                                    'boat_id' => $boat->id,
                                    'boat_name' => $boat->name,
                                    'requested_id' => request('boat_id'),
                                    'is_selected' => $isSelected
                                ]);
                            @endphp
                            <option value="{{ $boat->id }}" {{ $isSelected ? 'selected' : '' }}>
                                {{ $boat->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label for="hotel_id">Filter by Hotel</label>
                    <select name="hotel_id" id="hotel_id" class="form-control filter-select">
                        <option value="">All Hotels</option>
                        @foreach($hotels as $hotel)
                            <option value="{{ $hotel->id }}" {{ request('hotel_id') == $hotel->id ? 'selected' : '' }}>
                                {{ $hotel->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label for="agency_id">Filter by Agency</label>
                    <select name="agency_id" id="agency_id" class="form-control filter-select">
                        <option value="">All Agencies</option>
                        @foreach($agencies as $agency)
                            @php
                                $isSelected = request('agency_id') == $agency->id;
                                \Log::info('Agency Option:', [
                                    'agency_id' => $agency->id,
                                    'agency_name' => $agency->name,
                                    'requested_id' => request('agency_id'),
                                    'is_selected' => $isSelected
                                ]);
                            @endphp
                            <option value="{{ $agency->id }}" {{ $isSelected ? 'selected' : '' }}>
                                {{ $agency->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label for="transfer_contract_id">Filter by Transfer Contract</label>
                    <select name="transfer_contract_id" id="transfer_contract_id" class="form-control filter-select">
                        <option value="">All Transfer Contracts</option>
                        @foreach($transferContracts as $contract)
                            <option value="{{ $contract->id }}" {{ request('transfer_contract_id') == $contract->id ? 'selected' : '' }}>
                                {{ $contract->company_name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
        <div class="mt-3">
            <button type="submit" class="btn btn-primary">Apply Filter</button>
            @if(request()->hasAny(['boat_id', 'hotel_id', 'agency_id', 'transfer_contract_id']))
                <a href="{{ route('trip-programs.show', $tripProgram) }}" class="btn btn-secondary">Clear Filter</a>
                <a href="{{ request()->fullUrlWithQuery(['export' => 'pdf']) }}" class="btn btn-success">
                    <i class="fas fa-file-pdf"></i> Export Filtered PDF
                </a>
                <a href="{{ request()->fullUrlWithQuery(['export' => 'excel']) }}" class="btn btn-success">
                    <i class="fas fa-file-excel"></i> Export Filtered Excel
                </a>
            @endif
        </div>
    </form>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const filterSelects = document.querySelectorAll('.filter-select');
        const filterForm = document.getElementById('filterForm');

        // Log current filter values for debugging
        console.log('Current filter values:', {
            boat_id: document.querySelector('#boat_id').value,
            hotel_id: document.querySelector('#hotel_id').value,
            agency_id: document.querySelector('#agency_id').value,
            transfer_contract_id: document.querySelector('#transfer_contract_id').value
        });

        filterSelects.forEach(select => {
            select.addEventListener('change', function() {
                console.log('Filter changed:', this.name, 'to value:', this.value);

                // Get current URL parameters
                const currentUrl = new URL(window.location.href);

                // Update or remove the changed parameter
                if (this.value) {
                    currentUrl.searchParams.set(this.name, this.value);
                } else {
                    currentUrl.searchParams.delete(this.name);
                }

                console.log('Submitting form with values:', Object.fromEntries(currentUrl.searchParams));

                // Navigate to the new URL
                window.location.href = currentUrl.toString();
            });
        });
    });
    </script>

    <div class="table-responsive" style="overflow-x:auto">
        @if(isset($filteredFamilies) && $filteredFamilies->isEmpty())
            <div class="alert alert-info">No records found matching the selected filters.</div>
        @else
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
        @foreach($programFamilies as $idx => $fam)
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
        @endif
    </div>
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

