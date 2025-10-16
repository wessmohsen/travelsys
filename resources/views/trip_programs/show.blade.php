@extends('layouts.app')
@section('title','Daily Report')

@section('content')
<div class="card">
    <div style="display:flex;gap:8px;flex-wrap:wrap">
        <a class="btn" href="{{ route('trip-programs.index') }}">&larr; Back</a>
        <a class="btn" href="{{ route('trip-programs.show', $tripProgram) }}?export=pdf">Export PDF</a>
        <a class="btn" href="{{ route('trip-programs.show', $tripProgram) }}?export=excel">Export Excel</a>
        <a class="btn" href="{{ route('trip-programs.edit',$tripProgram) }}">Edit</a>
    </div>
</div>

<br>

<div class="card">
    <h3 style="margin-top:0">Daily Report — {{ $tripProgram->date ? $tripProgram->date->format('Y-m-d') : 'N/A' }}</h3>
    <div class="grid grid-3" style="margin-bottom:10px">
        <div><strong>Trip:</strong> {{ $tripProgram->trip->name ?? '-' }}</div>
        <div><strong>Status:</strong> {{ ucfirst($tripProgram->status) }}</div>
    </div>
    <div class="grid grid-4" style="margin-bottom:10px">
        <div><strong>Adults:</strong> {{ $tripProgram->total_adults }}</div>
        <div><strong>Children:</strong> {{ $tripProgram->total_children }}</div>
        <div><strong>Infants:</strong> {{ $tripProgram->total_infants }}</div>
        <div><strong>Total Amount:</strong> {{ number_format($tripProgram->total_amount,2) }}</div>
    </div>
    @if($tripProgram->remarks)
        <div class="muted"><strong>Remarks:</strong> {{ $tripProgram->remarks }}</div>
    @endif
</div>

<br>

<div class="card">
    <h3 style="margin-top:0">Families / Groups (MARSA MU layout style)</h3>
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Customer / Group</th>
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
                <th>Transfer Name</th>
                <th>Transfer Phone</th>
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
                <td>
                    {{ $fam->customer->name ?? $fam->group_name ?? '-' }}
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
                <td>{{ $fam->transfer_name }}</td>
                <td>{{ $fam->transfer_phone }}</td>
                <td>{{ $fam->collect_egp !== null ? number_format($fam->collect_egp,2) : '' }}</td>
                <td>{{ $fam->collect_usd !== null ? number_format($fam->collect_usd,2) : '' }}</td>
                <td>{{ $fam->collect_eur !== null ? number_format($fam->collect_eur,2) : '' }}</td>
                <td>{{ $fam->remarks }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>

<p><strong>Organizer:</strong> {{ $tripProgram->organizer->name ?? 'N/A' }}</p>
<p><strong>Last Modified:</strong> {{ $tripProgram->last_modified_at ? $tripProgram->last_modified_at->format('Y-m-d H:i') : 'N/A' }}</p>
@endsection
