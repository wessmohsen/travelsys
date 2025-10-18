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
                <label class="muted">From Date</label>
                <input type="text" name="from_date" value="{{ request('from_date') ? date('d-m-Y', strtotime(request('from_date'))) : '' }}" class="form-control date-input" autocomplete="off" />
            </div>
            <div style="flex: 1;">
                <label class="muted">To Date</label>
                <input type="text" name="to_date" value="{{ request('to_date') ? date('d-m-Y', strtotime(request('to_date'))) : '' }}" class="form-control date-input" autocomplete="off" />
            </div>

            @push('scripts')
            <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
            <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    flatpickr('.date-input', {
                        dateFormat: "d-m-Y",
                        allowInput: true,
                        altInput: true,
                        altFormat: "d-m-Y",
                        defaultHour: 12
                    });
                });
            </script>
            @endpush
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
                <a href="{{ route('trip-programs.index') }}" class="btn btn-secondary">Clear Filters</a>
            </div>
            @can('create-trip-programs')
            <div>
                <a href="{{ route('trip-programs.create') }}" class="btn btn-success">+ New Daily Program</a>
            </div>
            @endcan
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
                    @canany(['edit-trip-programs', 'delete-trip-programs'])
                    <th style="width:220px">Actions</th>
                    @endcanany
                </tr>
            </thead>
            <tbody>
                @forelse($programs as $p)
                    <tr>
                        <td>{{ $p->date->format('d-m-Y') }}</td>
                        <td>{{ $p->trip->name ?? '-' }}</td>
                        <td>{{ $p->organizer->name ?? '-' }}</td>
                        <td><span class="badge bg-info text-dark">{{ ucfirst($p->status) }}</span></td>
                        <td>{{ $p->remarks ?? '-' }}</td>
                        @canany(['edit-trip-programs', 'delete-trip-programs'])
                        <td class="actions">
                            @can('view-trip-programs')
                            <a class="btn btn-primary btn-sm" href="{{ route('trip-programs.show',$p) }}">View</a>
                            @endcan

                            @can('edit-trip-programs')
                            <a class="btn btn-warning btn-sm" href="{{ route('trip-programs.edit',$p) }}">Edit</a>
                            @endcan

                            @can('delete-trip-programs')
                            <form action="{{ route('trip-programs.destroy',$p) }}" method="post" class="delete-form" style="display:inline">
                                @csrf @method('DELETE')
                                <button type="button" class="btn btn-danger btn-sm delete-btn" data-message="Are you sure you want to delete this program?">Delete</button>
                            </form>
                            @endcan
                        </td>
                        @endcanany
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

    @include('partials.delete-modal')
</div>
@endsection
