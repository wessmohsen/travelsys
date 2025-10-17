@extends('layouts.app')
@section('content')
<div class="container-fluid">
    <h1>Add New Hotel</h1>
    <form method="POST" action="{{ route('hotels.store') }}">
        @csrf
        <div class="row">
            <div class="col-md-6 mb-3">
                <label>Name</label>
                <input type="text" name="name" value="{{ old('name') }}" class="form-control" required>
            </div>
            <div class="col-md-6 mb-3">
                <label>Status</label>
                <select name="status" class="form-control">
                    <option value="active">Active</option>
                    <option value="inactive">Inactive</option>
                </select>
            </div>
            <div class="col-md-6 mb-3">
                <label>Phone</label>
                <input type="text" name="phone" value="{{ old('phone') }}" class="form-control">
            </div>
            <div class="col-md-6 mb-3">
                <label>Website</label>
                <input type="url" name="website" value="{{ old('website') }}" class="form-control">
            </div>
            <div class="col-md-6 mb-3">
                <label>Location URL</label>
                <input type="url" name="location_url" value="{{ old('location_url') }}" class="form-control">
            </div>
            <div class="col-md-6 mb-3">
                <label>Location Ordering</label>
                <input type="number" name="location_ordering" value="{{ old('location_ordering', 0) }}" class="form-control">
            </div>
            <div class="col-12 mb-3">
                <label>Address</label>
                <textarea name="address" class="form-control" rows="3">{{ old('address') }}</textarea>
            </div>
            <div class="col-12 mb-3">
                <label>Description</label>
                <textarea name="description" class="form-control" rows="5">{{ old('description') }}</textarea>
            </div>
        </div>
        <button type="submit" class="btn btn-primary">Create Hotel</button>
    </form>
</div>
@endsection
