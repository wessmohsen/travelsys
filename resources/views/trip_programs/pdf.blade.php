<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <style>
        * {
            font-family: DejaVu Sans, Arial, sans-serif;
        }
        body {
            font-size: 12px;
            line-height: 1.3;
            margin: 0;
            padding: 10px;
        }
        .daily-report-header {
            margin-bottom: 20px;
        }
        .daily-report-header h2 {
            margin: 0 0 10px 0;
            font-size: 18px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px;
            font-size: 10px;
        }
        table th, table td {
            border: 1px solid #ddd;
            padding: 4px;
            font-size: 10px;
        }
        .currency-value {
            text-align: right;
            padding-right: 8px;
        }
        .info-row {
            margin-bottom: 10px;
        }
        .info-row span {
            margin-right: 15px;
        }
    </style>
</head>
<body>
    <div class="daily-report-header">
        <h2><strong>Trip:</strong> {{ $tripProgram->trip->name }} | {{ date('Y-m-d', strtotime($tripProgram->date)) }} </h2>
        <div class="info-row">
            <span><strong>Status:</strong> {{ ucfirst($tripProgram->status) }}</span>
            <span><strong>Organizer:</strong> {{ optional($tripProgram->organizer)->name ?: '-' }}</span>
            <span><strong>Last Modified:</strong> {{ $tripProgram->updated_at ? date('Y-m-d H:i', strtotime($tripProgram->updated_at)) : '-' }}</span>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                @if($showCustomerColumn)
                <th>Customer/Group</th>
                @endif
                <th>A</th>
                <th>C</th>
                <th>I</th>
                <th>Hotel</th>
                <th>Room</th>
                <th>Pickup</th>
                <th>Activity</th>
                <th>Size</th>
                <th>Nationality</th>
                <th>Boat</th>
                <th>Guide</th>
                <th>Agency</th>
                <th>Driver/Vehicle</th>
                <th>EGP</th>
                <th>USD</th>
                <th>EUR</th>
                <th>Remarks</th>
            </tr>
        </thead>
        <tbody>
            @foreach($families ?? $tripProgram->families as $family)
                <tr>
                    @if($showCustomerColumn)
                    <td>
                        @if($family->customer_id)
                            @foreach(\App\Models\Customer::whereIn('id', $family->customer_id)->get() as $customer)
                                {{ $customer->name }}<br>
                            @endforeach
                        @endif
                        @if($family->group_name)
                            {{ $family->group_name }}
                        @endif
                    </td>
                    @endif
                    <td>{{ $family->adults ?: '0' }}</td>
                    <td>{{ $family->children ?: '0' }}</td>
                    <td>{{ $family->infants ?: '0' }}</td>
                    <td>{{ optional($family->hotel)->name ?: '-' }}</td>
                    <td>{{ $family->room_number ?: '-' }}</td>
                    <td>{{ $family->pickup_time ?: '-' }}</td>
                    <td>{{ $family->activity ?: '-' }}</td>
                    <td>{{ $family->size ?: '-' }}</td>
                    <td>{{ $family->nationality ?: '-' }}</td>
                    <td>{{ optional($family->boat)->name ?: '-' }}</td>
                    <td>{{ optional($family->guide)->name ?: '-' }}</td>
                    <td>{{ optional($family->agency)->name ?: '-' }}</td>
                    <td>
                        @if($family->transferContract && $family->transferContract->driver)
                            {{ $family->transferContract->driver->name }}
                            @if($family->transferContract->company_name)
                                / {{ $family->transferContract->company_name }}
                            @endif
                            @if($family->transferContract->driver->phone)
                                / {{ $family->transferContract->driver->phone }}
                            @endif
                            @if($family->transferContract->driver->alternative_phone)
                                / {{ $family->transferContract->driver->alternative_phone }}
                            @endif
                            @if($family->transferContract->vehicle)
                                / {{ $family->transferContract->vehicle->model }} ({{ $family->transferContract->vehicle->plate_number }})
                            @endif
                        @else
                            -
                        @endif
                    </td>
                    <td class="currency-value">{{ $family->collect_egp ? number_format($family->collect_egp, 2) : '0.00' }}</td>
                    <td class="currency-value">{{ $family->collect_usd ? number_format($family->collect_usd, 2) : '0.00' }}</td>
                    <td class="currency-value">{{ $family->collect_eur ? number_format($family->collect_eur, 2) : '0.00' }}</td>
                    <td>{{ $family->remarks ?: '-' }}</td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td colspan="{{ $showCustomerColumn ? 14 : 13 }}" style="text-align: right;"><strong>Totals:</strong></td>
                <td class="currency-value"><strong>{{ number_format($families->sum('collect_egp'), 2) }}</strong></td>
                <td class="currency-value"><strong>{{ number_format($families->sum('collect_usd'), 2) }}</strong></td>
                <td class="currency-value"><strong>{{ number_format($families->sum('collect_eur'), 2) }}</strong></td>
                <td></td>
            </tr>
        </tfoot>
    </table>

    @if($tripProgram->remarks)
    <div style="margin-top: 20px;">
        <strong>General Notes:</strong><br>
        {{ $tripProgram->remarks }}
    </div>
    @endif
</body>
</html>
