@extends('layouts.app')
@section('content')
<div class="container-fluid">
    <h1 class="mb-4">Dashboard</h1>
    <div class="row">
        <div class="col-lg-3 col-6">
            <div class="small-box bg-info"><div class="inner"><h3>{{ $bookingsCount }}</h3><p>Total Bookings</p></div><div class="icon"><i class="fas fa-calendar-check"></i></div></div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box bg-success"><div class="inner"><h3>{{ $customersCount }}</h3><p>Total Customers</p></div><div class="icon"><i class="fas fa-users"></i></div></div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box bg-warning text-dark"><div class="inner"><h3>{{ $tripsCount }}</h3><p>Total Trips</p></div><div class="icon"><i class="fas fa-map"></i></div></div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box bg-danger"><div class="inner"><h3>${{ $revenue }}</h3><p>Total Revenue</p></div><div class="icon"><i class="fas fa-dollar-sign"></i></div></div>
        </div>
    </div>
    <div class="card mt-4">
        <div class="card-header"><h3 class="card-title">Latest Bookings</h3></div>
        <div class="card-body table-responsive">
            <table class="table table-bordered table-hover">
                <thead><tr><th>ID</th><th>Customer</th><th>Trip</th><th>Status</th><th>Price</th><th>Date</th></tr></thead>
                <tbody>
                    @foreach($latestBookings as $booking)
                        <tr>
                            <td>{{ $booking->id }}</td>
                            <td>{{ $booking->customer->name ?? 'N/A' }}</td>
                            <td>{{ $booking->trip->name ?? 'N/A' }}</td>
                            <td><span class="badge @if($booking->status=='confirmed') bg-success @elseif($booking->status=='pending') bg-warning @else bg-danger @endif">{{ ucfirst($booking->status) }}</span></td>
                            <td>${{ number_format($booking->price,2) }}</td>
                            <td>{{ $booking->date }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
