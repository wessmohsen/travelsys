@extends('layouts.app')
@section('title','Daily Trip Programs')

@section('content')
<div class="container-fluid">
    <h1 class="mb-4">Trip Programs</h1>
    @include('partials.breadcrumbs', ['crumbs' => [
        ['text' => 'Trip Programs']
    ]])

    <div class="card p-3 mb-4">
        <form method="get" class="d-flex flex-wrap gap-3 align-items-end">
            <div style="flex: 1;">
                <label class="muted">Date</label>
                <input type="date" name="date" value="{{ request('date') }}" class="form-control" />
            </div>
            <div style="flex: 1;">
                <label class="muted">Trip</label>
                <select name="trip_id" class="form-control">
                    <option value="">All</option>
                    @foreach($trips as $t)
                        <option value="{{ $t->id }}" @selected(request('trip_id')==$t->id)>{{ $t->name }}</option>
                    @endforeach
                </select>
            </div>
            <div style="flex: 1;">
                <label class="muted">Status</label>
                <select name="status" class="form-control">
                    <option value="">All</option>
                    @foreach(['draft','confirmed','done'] as $st)
                        <option value="{{ $st }}" @selected(request('status')==$st)>{{ ucfirst($st) }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <button class="btn btn-primary">Filter</button>
            </div>
            <div>
                <a href="{{ route('trip-programs.create') }}" class="btn btn-success">+ New Daily Program</a>
            </div>
        </form>
    </div>

    <div class="card p-3">
        <table class="table table-striped table-hover">
            <thead class="table-dark">
                <tr>
                    <th>Date</th>
                    <th>Trip</th>
                    <th>Organizer</th>
                    <th>Status</th>
                    <th>Remarks</th>
                    <th style="width:220px">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($programs as $p)
                    <tr>
                        <td>{{ $p->date->format('Y-m-d') }}</td>
                        <td>{{ $p->trip->name ?? '-' }}</td>
                        <td>{{ $p->organizer->name ?? '-' }}</td>
                        <td><span class="badge bg-info text-dark">{{ ucfirst($p->status) }}</span></td>
                        <td>{{ $p->remarks ?? '-' }}</td>
                        <td class="actions">
                            <a class="btn btn-primary btn-sm" href="{{ route('trip-programs.show',$p) }}">View</a>
                            <a class="btn btn-warning btn-sm" href="{{ route('trip-programs.edit',$p) }}">Edit</a>
                            <form action="{{ route('trip-programs.destroy',$p) }}" method="post" style="display:inline" onsubmit="return confirm('Delete program?')">
                                @csrf @method('DELETE')
                                <button class="btn btn-danger btn-sm">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="text-center">No programs found.</td></tr>
                @endforelse
            </tbody>
        </table>

        <div class="mt-3 d-flex justify-content-center">
            {{ $programs->links('pagination::bootstrap-4') }}
        </div>
    </div>
</div>
@endsection
