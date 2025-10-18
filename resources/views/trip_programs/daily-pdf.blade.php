<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Daily Trip Programs - {{ $date->format('d-m-Y') }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: DejaVu Sans, Arial, sans-serif;
            font-size: 9px;
            line-height: 1.3;
            padding: 10px;
        }
        .page-header {
            text-align: center;
            margin-bottom: 10px;
            padding-bottom: 5px;
            border-bottom: 2px solid #333;
        }
        .page-header h1 {
            font-size: 16px;
            margin-bottom: 3px;
        }
        .page-header h2 {
            font-size: 12px;
            color: #666;
        }
        .trip-section {
            margin-bottom: 15px;
        }
        .trip-header {
            background: #f4f4f4;
            padding: 6px;
            margin-bottom: 8px;
            border: 1px solid #ddd;
        }
        .trip-header h3 {
            font-size: 11px;
            font-weight: bold;
        }
        .program-card {
            border: 1px solid #ddd;
            margin-bottom: 12px;
        }
        .program-header {
            background: #f9f9f9;
            padding: 6px;
            border-bottom: 1px solid #ddd;
            overflow: hidden;
        }
        .program-header-left {
            float: left;
            font-weight: bold;
            font-size: 9px;
        }
        .program-header-right {
            float: right;
        }
        .status-badge {
            display: inline-block;
            padding: 3px 8px;
            border-radius: 3px;
            font-size: 8px;
            font-weight: bold;
        }
        .status-confirmed { background: #d4edda; color: #155724; }
        .status-draft { background: #fff3cd; color: #856404; }
        .status-done { background: #cce5ff; color: #004085; }
        .program-details {
            padding: 6px;
            background: #fff;
            overflow: hidden;
        }
        .program-details > div {
            float: left;
            margin-right: 12px;
            margin-bottom: 3px;
        }
        .program-details strong {
            font-weight: bold;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 5px;
            font-size: 7px;
        }
        table th {
            background: #f8f9fa;
            border: 1px solid #dee2e6;
            padding: 4px 3px;
            text-align: left;
            font-weight: bold;
            font-size: 7px;
        }
        table td {
            border: 1px solid #dee2e6;
            padding: 4px 3px;
            vertical-align: top;
        }
        .text-center {
            text-align: center;
        }
        .text-end {
            text-align: right;
        }
        .no-families {
            padding: 15px;
            text-align: center;
            color: #666;
            font-style: italic;
        }
        .clearfix::after {
            content: "";
            display: table;
            clear: both;
        }
    </style>
</head>
<body>
    <div class="page-header">
        <h1>Daily Trip Programs</h1>
        <h2>{{ $date->format('d-m-Y') }}</h2>
    </div>

    @forelse($groupedPrograms as $tripId => $programs)
        @php
            $trip = $programs->first()->trip;
        @endphp
        <div class="trip-section">
            <div class="trip-header">
                <h3>{{ $trip->name }}</h3>
            </div>

            @foreach($programs as $program)
                <div class="program-card">
                    <div class="program-header clearfix">
                        <div class="program-header-left">
                            Program Details
                            <span class="status-badge status-{{ $program->status }}">
                                {{ ucfirst($program->status) }}
                            </span>
                        </div>
                    </div>

                    <div class="program-details clearfix">
                        <div>
                            <strong>Organizer:</strong> {{ $program->organizer->name ?? 'Not assigned' }}
                        </div>
                        <div>
                            <strong>Remarks:</strong> {{ $program->remarks ?? 'No remarks' }}
                        </div>
                    </div>

                    @if($program->families->isNotEmpty())
                        <table>
                            <thead>
                                <tr>
                                    <th>Agency</th>
                                    <th class="text-center" style="width: 25px;">A</th>
                                    <th class="text-center" style="width: 25px;">C</th>
                                    <th class="text-center" style="width: 25px;">I</th>
                                    <th>Hotel</th>
                                    <th style="width: 40px;">Room</th>
                                    <th style="width: 45px;">Pickup</th>
                                    <th style="width: 40px;">Activity</th>
                                    <th style="width: 30px;">Size</th>
                                    <th>Nationality</th>
                                    <th>Boat Master</th>
                                    <th>Guide Name</th>
                                    <th>Transfer Contract</th>
                                    <th class="text-end" style="width: 50px;">EGP</th>
                                    <th class="text-end" style="width: 50px;">USD</th>
                                    <th class="text-end" style="width: 50px;">EUR</th>
                                    <th>Remarks</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($program->families as $family)
                                    <tr>
                                        <td>{{ $family->agency->name ?? '-' }}</td>
                                        <td class="text-center">{{ $family->adults }}</td>
                                        <td class="text-center">{{ $family->children }}</td>
                                        <td class="text-center">{{ $family->infants }}</td>
                                        <td>{{ $family->hotel->name ?? '-' }}</td>
                                        <td>{{ $family->room_number ?? '-' }}</td>
                                        <td>{{ $family->pickup_time ? \Carbon\Carbon::parse($family->pickup_time)->format('H:i') : '-' }}</td>
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
                                        <td>
                                            @if($family->transferContract)
                                                @php
                                                    $phones = [];
                                                    if($family->transferContract->phone) {
                                                        $phones[] = $family->transferContract->phone;
                                                    }
                                                    if($family->transferContract->alt_phone) {
                                                        $phones[] = $family->transferContract->alt_phone;
                                                    }
                                                @endphp
                                                {{ $family->transferContract->driver->name ?? 'No Driver' }} |
                                                {{ $family->transferContract->company_name }} |
                                                {{ implode(' | ', $phones) }}
                                            @else
                                                -- Select Contract --
                                            @endif
                                        </td>
                                        <td class="text-end">{{ number_format($family->collect_egp ?? 0, 2) }}</td>
                                        <td class="text-end">{{ number_format($family->collect_usd ?? 0, 2) }}</td>
                                        <td class="text-end">{{ number_format($family->collect_eur ?? 0, 2) }}</td>
                                        <td>{{ $family->remarks ?? '-' }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <div class="no-families">No program families recorded</div>
                    @endif
                </div>
            @endforeach
        </div>
    @empty
        <div style="text-align: center; padding: 40px; color: #666;">
            <p>No programs found for this date.</p>
        </div>
    @endforelse
</body>
</html>
