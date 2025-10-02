@extends('layouts.app')
@section('content')
    <div class="container-fluid">
        <h1>Edit Booking</h1>
        <form method="POST" action="{{ route('bookings.update', $item->id) }}">
            @csrf @method('PUT')

            <div class="mb-3">
                <label>Customer</label>
                <select name="customer_id" id="customer_id" class="form-control">
                    @if($item->customer)
                        <option value="{{ $item->customer->id }}" selected>{{ $item->customer->name }}</option>
                    @endif
                </select>
            </div>

            <div class="mb-3">
                <label>Trip</label>
                <select name="trip_id" id="trip_id" class="form-control">
                    @if($item->trip)
                        <option value="{{ $item->trip->id }}" selected>{{ $item->trip->name }}</option>
                    @endif
                </select>
            </div>

            <div class="mb-3">
                <label>Date</label>
                <input type="date" name="date" value="{{ $item->date }}" class="form-control" required>
            </div>

            <div class="mb-3">
                <label>Status</label>
                <select name="status" class="form-control">
                    <option value="pending" @if($item->status == 'pending') selected @endif>Pending</option>
                    <option value="confirmed" @if($item->status == 'confirmed') selected @endif>Confirmed</option>
                    <option value="cancelled" @if($item->status == 'cancelled') selected @endif>Cancelled</option>
                </select>
            </div>

            <div class="mb-3">
                <label>Price</label>
                <input type="number" step="0.01" name="price" value="{{ $item->price }}" class="form-control" required>
            </div>

            <button class="btn btn-success">Update</button>
        </form>
    </div>
@endsection

@section('scripts')
    <!-- Select2 -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    {{--
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script> --}}

    <script>
        jQuery(document).ready(function ($) {
            // Customer search
            $('#customer_id').select2({
                ajax: {
                    url: '{{ route("customers.search") }}',
                    dataType: 'json',
                    delay: 250,
                    data: function (params) {
                        return { q: params.term };
                    },
                    processResults: function (data) {
                        return { results: data.results };
                    },
                    cache: true
                },
                placeholder: 'Select a customer',
                minimumInputLength: 1,
            });

            // Trip search
            $('#trip_id').select2({
                placeholder: 'Select a trip',
                ajax: {
                    url: '{{ route("ajax.trips") }}',
                    dataType: 'json',
                    delay: 250,
                    data: function (params) {
                        return { q: params.term };
                    },
                    processResults: function (data) {
                        return { results: data.results };
                    }
                }
            });
        });
    </script>
@endsection
