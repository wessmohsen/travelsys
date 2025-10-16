@extends('layouts.app')
@section('title','Daily Trip Programs')

@section('content')
<div class="card">
    <form method="get" class="grid grid-4" style="align-items:end">
        <div>
            <label class="muted">Date</label>
            <input type="date" name="date" value="{{ request('date') }}" class="form-control" />
        </div>
        <div>
            <label class="muted">Trip</label>
            <select name="trip_id">
                <option value="">All</option>
                @foreach($trips as $t)
                    <option value="{{ $t->id }}" @selected(request('trip_id')==$t->id)>{{ $t->name }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="muted">Status</label>
            <select name="status">
                <option value="">All</option>
                @foreach(['draft','confirmed','done'] as $st)
                    <option value="{{ $st }}" @selected(request('status')==$st)>{{ ucfirst($st) }}</option>
                @endforeach
            </select>
        </div>
        <div><button class="btn btn-primary">Filter</button></div>
        <div><a href="{{ route('trip-programs.create') }}" class="btn">+ New Daily Program</a></div>
    </form>
</div>

<br>

<div class="card">
    <table>
        <thead>
            <tr>
                <th>Date</th>
                <th>Trip</th>
                <th>Guide</th>
                <th>Company</th>
                <th>Totals (A/C/I)</th>
                <th>Total Amount</th>
                <th>Status</th>
                <th style="width:220px">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($programs as $p)
                <tr>
                    <td>{{ $p->date->format('Y-m-d') }}</td>
                    <td>{{ $p->trip->name ?? '-' }}</td>
                    <td>{{ $p->guide->name ?? '-' }}</td>
                    <td>{{ $p->company->name ?? '-' }}</td>
                    <td>{{ $p->total_adults }}/{{ $p->total_children }}/{{ $p->total_infants }}</td>
                    <td>{{ number_format($p->total_amount, 2) }}</td>
                    <td>{{ ucfirst($p->status) }}</td>
                    <td class="actions">
                        <a class="btn btn-primary" href="{{ route('trip-programs.show',$p) }}">View</a>
                        <a class="btn" href="{{ route('trip-programs.edit',$p) }}">Edit</a>
                        <form action="{{ route('trip-programs.destroy',$p) }}" method="post" style="display:inline" onsubmit="return confirm('Delete program?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="9">No programs found.</td></tr>
            @endforelse
        </tbody>
    </table>

    <div style="margin-top:10px">
        {{ $programs->links() }}
    </div>
</div>
@endsection
