@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <h1>Create Agency</h1>
    @include('partials.breadcrumbs')

    <form method="POST" action="{{ route('agencies.store') }}">
        @csrf

        <div class="mb-3">
            <label>Name *</label>
            <input type="text" name="name" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" class="form-control">
        </div>

        <div class="mb-3">
            <label>Phone</label>
            <input type="text" name="phone" class="form-control">
        </div>

        <div class="mb-3">
            <label>Tax Number</label>
            <input type="text" name="tax_number" class="form-control">
        </div>

        <div class="mb-3 form-check">
            <input type="checkbox" name="is_partner" value="1" class="form-check-input">
            <label class="form-check-label">Is Partner</label>
        </div>

        <h4>Address</h4>
        <div class="row">
            <div class="col-md-6 mb-3">
                <label>Street</label>
                <input type="text" name="street" class="form-control">
            </div>
            <div class="col-md-2 mb-3">
                <label>Number</label>
                <input type="text" name="number" class="form-control">
            </div>
            <div class="col-md-2 mb-3">
                <label>Zipcode</label>
                <input type="text" name="zipcode" class="form-control">
            </div>
            <div class="col-md-2 mb-3">
                <label>City</label>
                <input type="text" name="city" class="form-control">
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label>State</label>
                <input type="text" name="state" class="form-control">
            </div>
            <div class="col-md-6 mb-3">
                <label>Country</label>
                <input type="text" name="country" class="form-control">
            </div>
        </div>

        <div class="mb-3">
            <label>Notes</label>
            <textarea name="notes" class="form-control"></textarea>
        </div>

        <button type="submit" class="btn btn-success">Save</button>
    </form>
</div>
@endsection
