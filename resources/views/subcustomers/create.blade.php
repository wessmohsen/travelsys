@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <h1>Add Family Member for {{ $customer->first_name }} {{ $customer->last_name }}</h1>
    @include('partials.flash')

    <form action="{{ route('customers.subcustomers.store', $customer->id) }}" method="POST">
        @csrf

        <div class="mb-3">
            <label>Relation Type</label>
            <select name="relation_type" class="form-control" required>
                <option value="">-- Select --</option>
                <option value="adult">Adult</option>
                <option value="child">Child</option>
                <option value="infant">Infant</option>
            </select>
        </div>

        <div class="mb-3">
            <label>First Name</label>
            <input type="text" name="first_name" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Last Name</label>
            <input type="text" name="last_name" class="form-control">
        </div>

        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" class="form-control">
        </div>

        <div class="mb-3">
            <label>Hotel</label>
            <select name="hotel_id" class="form-control">
                <option value="">-- None --</option>
                @foreach($hotels as $hotel)
                    <option value="{{ $hotel->id }}">{{ $hotel->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label>Room Number</label>
            <input type="text" name="room_number" class="form-control">
        </div>

        <div class="mb-3">
            <label>Responsible Name</label>
            <input type="text" name="responsible_name" class="form-control">
        </div>

        <button type="submit" class="btn btn-success">Save</button>
        <a href="{{ route('customers.show', $customer->id) }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
