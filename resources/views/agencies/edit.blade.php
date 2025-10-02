@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <h1>Edit Agency: {{ $agency->name }}</h1>
    @include('partials.breadcrumbs')

    <form method="POST" action="{{ route('agencies.update', $agency->id) }}">
        @csrf @method('PUT')

        <div class="mb-3">
            <label>Name *</label>
            <input type="text" name="name" value="{{ $agency->name }}" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" value="{{ $agency->email }}" class="form-control">
        </div>

        <div class="mb-3">
            <label>Phone</label>
            <input type="text" name="phone" value="{{ $agency->phone }}" class="form-control">
        </div>

        <div class="mb-3">
            <label>Tax Number</label>
            <input type="text" name="tax_number" value="{{ $agency->tax_number }}" class="form-control">
        </div>

        <div class="mb-3 form-check">
            <input type="checkbox" name="is_partner" value="1" class="form-check-input" {{ $agency->is_partner ? 'checked' : '' }}>
            <label class="form-check-label">Is Partner</label>
        </div>

        <h4>Address</h4>
        <div class="row">
            <div class="col-md-6 mb-3">
                <label>Street</label>
                <input type="text" name="street" value="{{ $agency->street }}" class="form-control">
            </div>
            <div class="col-md-2 mb-3">
                <label>Number</label>
                <input type="text" name="number" value="{{ $agency->number }}" class="form-control">
            </div>
            <div class="col-md-2 mb-3">
                <label>Zipcode</label>
                <input type="text" name="zipcode" value="{{ $agency->zipcode }}" class="form-control">
            </div>
            <div class="col-md-2 mb-3">
                <label>City</label>
                <input type="text" name="city" value="{{ $agency->city }}" class="form-control">
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label>State</label>
                <input type="text" name="state" value="{{ $agency->state }}" class="form-control">
            </div>
            <div class="col-md-6 mb-3">
                <label>Country</label>
                <input type="text" name="country" value="{{ $agency->country }}" class="form-control">
            </div>
        </div>

        <div class="mb-3">
            <label>Notes</label>
            <textarea name="notes" class="form-control">{{ $agency->notes }}</textarea>
        </div>

        <button type="submit" class="btn btn-primary">Update</button>
    </form>
</div>
@endsection
