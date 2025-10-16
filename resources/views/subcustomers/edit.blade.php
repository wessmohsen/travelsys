@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <h1>Edit Family Member</h1>
    @include('partials.flash')

    <form action="{{ route('customers.subcustomers.update', [$customer->id, $item->id]) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label>Relation Type</label>
            <select name="relation_type" class="form-control" required>
                <option value="adult" {{ $item->relation_type == 'adult' ? 'selected' : '' }}>Adult</option>
                <option value="child" {{ $item->relation_type == 'child' ? 'selected' : '' }}>Child</option>
                <option value="infant" {{ $item->relation_type == 'infant' ? 'selected' : '' }}>Infant</option>
            </select>
        </div>

        <div class="mb-3">
            <label>First Name</label>
            <input type="text" name="first_name" class="form-control" value="{{ $item->first_name }}" required>
        </div>

        <div class="mb-3">
            <label>Last Name</label>
            <input type="text" name="last_name" class="form-control" value="{{ $item->last_name }}">
        </div>

        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" class="form-control" value="{{ $item->email }}">
        </div>

        <div class="mb-3">
            <label>Hotel</label>
            <select name="hotel_id" class="form-control">
                <option value="">-- None --</option>
                @foreach($hotels as $hotel)
                    <option value="{{ $hotel->id }}" {{ $item->hotel_id == $hotel->id ? 'selected' : '' }}>
                        {{ $hotel->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label>Room Number</label>
            <input type="text" name="room_number" class="form-control" value="{{ $item->room_number }}">
        </div>

        <div class="mb-3">
            <label>Responsible Name</label>
            <input type="text" name="responsible_name" class="form-control" value="{{ $item->responsible_name }}">
        </div>

        <button type="submit" class="btn btn-success">Update</button>
        <a href="{{ route('customers.show', $customer->id) }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
