@extends('layouts.app')
@section('title', 'Daily Trip Programs')

@section('content')
<div class="container-fluid">
    <h1 class="mb-4">Daily Trip Programs</h1>
    @include('partials.breadcrumbs', ['crumbs' => [
        ['text' => 'Daily Trip Programs']
    ]])

    <div class="card mb-4">
        <div class="card-body">
            <label class="text-muted small mb-2">SELECT DATE</label>
            <div class="row g-3 align-items-center">
                <div class="col-md-4">
                    <input type="text"
                        name="date"
                        value="{{ $date->format('d-m-Y') }}"
                        class="form-control date-input"
                        autocomplete="off" />
                </div>
                <div class="col">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <button class="btn btn-primary" onclick="event.preventDefault(); window.location.href='{{ route('trip-programs.daily') }}?date=' + document.querySelector('.date-input').value">
                                View Programs
                            </button>
                            <a href="{{ route('trip-programs.daily.export', ['date' => $date->format('d-m-Y')]) }}" class="btn btn-outline-primary ms-2">
                                Export PDF
                            </a>
                        </div>
                        <div>
                            <a href="{{ route('trip-programs.create') }}" class="btn btn-success d-inline-flex align-items-center">
                                <i class="bi bi-plus-lg me-1"></i>
                                New Daily Program
                            </a>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>    <div class="mb-3">
        <h5 class="text-muted mb-3">Programs for {{ $date->format('d-m-Y') }}</h5>

        @forelse($groupedPrograms as $tripId => $programs)
            @php
                $trip = $programs->first()->trip;
            @endphp
            <div class="mb-4">
                <div class="card">
                    <div class="card-header bg-white">
                        <h5 class="mb-0">{{ $trip->name }}</h5>
                    </div>
                    @foreach($programs as $program)
                        <div class="card-body border-bottom">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <div class="d-flex align-items-center gap-4">
                                    <div class="d-flex align-items-center">
                                        <h6 class="mb-0">Program Details</h6>
                                        <span class="badge bg-{{ $program->status === 'confirmed' ? 'success' : ($program->status === 'done' ? 'info' : 'warning') }} ms-2">
                                            {{ ucfirst($program->status) }}
                                        </span>
                                        <a href="{{ route('trip-programs.edit', $program->id) }}" class="btn btn-link btn-sm text-primary ms-2">
                                            <i class="bi bi-pencil-square"></i> Edit
                                        </a>
                                    </div>
                                </div>
                                <div class="d-flex align-items-center gap-4">
                                    <div>
                                        <label class="text-muted small">Organizer:</label>
                                        <span class="ms-2">{{ $program->organizer->name ?? 'Not assigned' }}</span>
                                    </div>
                                    <div>
                                        <label class="text-muted small">Remarks:</label>
                                        <span class="ms-2">{{ $program->remarks ?? 'No remarks' }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="row g-3">
                                <div class="col-12">
                                    <div class="table-responsive">
                                        <table class="table table-sm table-hover align-middle w-100">
                                            <thead class="table-light">
                                                <tr>
                                                    <th class="text-center" style="width: 40px;">A</th>
                                                    <th class="text-center" style="width: 40px;">C</th>
                                                    <th class="text-center" style="width: 40px;">I</th>
                                                    <th>Hotel</th>
                                                    <th style="width: 80px;">Room</th>
                                                    <th style="width: 90px;">Pickup</th>
                                                    <th style="width: 80px;">Activity</th>
                                                    <th style="width: 60px;">Size</th>
                                                    <th>Nationality</th>
                                                    <th>Boat Master</th>
                                                    <th>Guide Name</th>
                                                    <th>Agency</th>
                                                    <th>Transfer Contract</th>
                                                    <th class="text-end" style="width: 100px;">EGP</th>
                                                    <th class="text-end" style="width: 100px;">USD</th>
                                                    <th class="text-end" style="width: 100px;">EUR</th>
                                                    <th>Remarks</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse($program->families as $family)
                                                    <tr>
                                                        <td class="text-center">{{ $family->adults }}</td>
                                                        <td class="text-center">{{ $family->children }}</td>
                                                        <td class="text-center">{{ $family->infants }}</td>
                                                        <td>{{ $family->hotel->name ?? '-' }}</td>
                                                        <td>{{ $family->room_number ?? '-' }}</td>
                                                        <td>{{ $family->pickup_time ? \Carbon\Carbon::parse($family->pickup_time)->format('H:i:s') : '-' }}</td>
                                                        <td>{{ $family->activity ?? '-' }}</td>
                                                        <td>{{ $family->size ?? '-' }}</td>
                                                        <td>{{ $family->nationality ?? '-' }}</td>
                                                        <td>
                                                            @if($family->boat_id)
                                                                {{ $family->boat?->name ?? '-' }}
                                                            @else
                                                                {{ $family->boat_master ?? '-' }}
                                                            @endif
                                                        </td>
                                                        <td>{{ $family->guide->name ?? '-' }}</td>
                                                        <td>{{ $family->agency->name ?? '-' }}</td>
                                                        <td>
                                                            @if($family->transferContract)
                                                                <div>{{ $family->transferContract->company_name }}</div>
                                                                <div class="small text-muted">
                                                                    @if($family->transferContract->phone)
                                                                        <div>{{ $family->transferContract->phone }}</div>
                                                                    @endif
                                                                    @if($family->transferContract->alt_phone)
                                                                        <div>{{ $family->transferContract->alt_phone }}</div>
                                                                    @endif
                                                                    @if($family->transferContract->driver)
                                                                        <div>Vehicle: {{ $family->transferContract->driver->vehicle_number ?? 'N/A' }}</div>
                                                                    @endif
                                                                </div>
                                                            @else
                                                                -
                                                            @endif
                                                        </td>
                                                        <td class="text-end">{{ number_format($family->collect_egp ?? 0, 2) }}</td>
                                                        <td class="text-end">{{ number_format($family->collect_usd ?? 0, 2) }}</td>
                                                        <td class="text-end">{{ number_format($family->collect_eur ?? 0, 2) }}</td>
                                                        <td>{{ $family->remarks ?? '-' }}</td>
                                                    </tr>
                                                @empty
                                                    <tr>
                                                        <td colspan="17" class="text-center text-muted">No program families</td>
                                                    </tr>
                                                @endforelse
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @empty
            <div class="alert alert-info">
                No programs found for this date.
            </div>
        @endforelse
    </div>
</div>

@endsection

@push('scripts')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="https://cdn.jsdelivr.net/npm/moment@2.29.4/moment.min.js"></script>
<style>
    .flatpickr-calendar {
        border: 1px solid #ddd !important;
        border-radius: 4px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1) !important;
        font-family: inherit;
        background: white;
    }
    .flatpickr-current-month {
        font-size: 1rem;
    }
    .flatpickr-weekdays {
        background: transparent;
        margin-top: 10px;
    }
    .flatpickr-weekday {
        background: transparent;
        color: #666;
        font-weight: normal;
    }
    .flatpickr-day {
        border-radius: 4px;
        margin: 2px;
        color: #333;
    }
    .flatpickr-day.selected {
        background: #0d6efd;
        border-color: #0d6efd;
    }
    .flatpickr-day.today:not(.selected) {
        border-color: #ddd;
        color: #333;
    }
    .flatpickr-day.disabled {
        color: #ccc;
    }
    .date-input {
        background: white !important;
        border-color: #ddd;
        padding: 0.375rem 0.75rem;
        font-size: 0.9rem;
    }
    .btn {
        font-size: 0.9rem;
    }
</style>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const enabledDates = @json($programDates);

        // Initialize input field with popup calendar
        flatpickr('.date-input', {
            dateFormat: "d-m-Y",
            allowInput: false,
            enable: enabledDates,
            defaultDate: "{{ $date->format('d-m-Y') }}",
            onChange: function(selectedDates, dateStr) {
                // Navigate to the selected date
                window.location.href = '{{ route('trip-programs.daily') }}?date=' + dateStr;
            }
        });
    });
</script>
@endpush
