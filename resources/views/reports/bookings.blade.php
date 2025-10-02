@extends('layouts.app')
@section('content')
    <div class="container-fluid">
        <h1>Bookings Report</h1>
        <form method="GET" action="{{ route('reports.bookings') }}" class="row g-3 mb-3">
            <div class="col-md-3"><input type="date" name="from" value="{{ request('from') }}" class="form-control"></div>
            <div class="col-md-3"><input type="date" name="to" value="{{ request('to') }}" class="form-control"></div>
            <div class="col-md-3">
                <select name="status" class="form-control">
                    <option value="">All</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="confirmed" {{ request('status') == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                    <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                </select>
            </div>
            <div class="col-md-3"><button class="btn btn-primary">Filter</button></div>
        </form>
        <div class="alert alert-info"><strong>Total Revenue:</strong> ${{ number_format($revenue, 2) }}</div>
        <div class="card">
            <div class="card-body table-responsive">
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Customer</th>
                            <th>Trip</th>
                            <th>Status</th>
                            <th>Price</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>@foreach($bookings as $booking)
                        <tr>
                            <td>{{ $booking->id }}</td>
                            <td>{{ $booking->customer->name ?? 'N/A' }}</td>
                            <td>{{ $booking->trip->name ?? 'N/A' }}</td>
                            <td>{{ ucfirst($booking->status) }}</td>
                            <td>${{ number_format($booking->price, 2) }}</td>
                            <td>{{ $booking->date }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                <div class="d-flex justify-content-center">
                    {{ $bookings->links('pagination::bootstrap-5') }}
                </div>
            </div>
        </div>
    </div>
@endsection
