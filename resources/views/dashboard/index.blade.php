@extends('layouts.app')
@section('title','Dashboard')

@section('content')
<div class="row">
  <div class="col-lg-3 col-6">
    <div class="small-box bg-info">
      <div class="inner">
        <h3>{{ $stats['bookings_total'] }}</h3>
        <p>Total Bookings</p>
      </div>
      <div class="icon">
        <i class="fas fa-clipboard-list"></i>
      </div>
    </div>
  </div>

  <div class="col-lg-3 col-6">
    <div class="small-box bg-success">
      <div class="inner">
        <h3>{{ $stats['trips_total'] }}</h3>
        <p>Total Trips</p>
      </div>
      <div class="icon">
        <i class="fas fa-route"></i>
      </div>
    </div>
  </div>

  <div class="col-lg-3 col-6">
    <div class="small-box bg-warning">
      <div class="inner">
        <h3>{{ $stats['customers_total'] }}</h3>
        <p>Total Customers</p>
      </div>
      <div class="icon">
        <i class="fas fa-users"></i>
      </div>
    </div>
  </div>

  <div class="col-lg-3 col-6">
    <div class="small-box bg-danger">
      <div class="inner">
        <h3>${{ number_format($stats['revenue_total'],2) }}</h3>
        <p>Total Revenue</p>
      </div>
      <div class="icon">
        <i class="fas fa-dollar-sign"></i>
      </div>
    </div>
  </div>
</div>

<div class="card">
  <div class="card-header">
    <h3 class="card-title">Recent Bookings</h3>
  </div>
  <div class="card-body p-0">
    <table class="table table-striped">
      <thead>
        <tr>
          <th>ID</th>
          <th>Customer</th>
          <th>Trip</th>
          <th>Status</th>
          <th>Price</th>
        </tr>
      </thead>
      <tbody>
        @forelse($recentBookings as $booking)
          <tr>
            <td>{{ $booking->id }}</td>
            <td>{{ $booking->customer->name ?? '-' }}</td>
            <td>{{ $booking->trip->name ?? '-' }}</td>
            <td><span class="badge bg-secondary">{{ $booking->status }}</span></td>
            <td>${{ number_format($booking->price,2) }}</td>
          </tr>
        @empty
          <tr>
            <td colspan="5" class="text-center">No Bookings Found</td>
          </tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>
@endsection
