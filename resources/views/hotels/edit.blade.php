@extends('layouts.app')
@section('content')
<div class="container-fluid">
    <h1>Edit Hotel</h1>
    <form method="POST" action="{{ route('hotels.update', $item->id) }}">
        @csrf
        @method('PUT')
        <div class="row">
            <div class="col-md-6 mb-3">
                <label>Name</label>
                <input type="text" name="name" value="{{ old('name', $item->name) }}" class="form-control" required>
            </div>
            <div class="col-md-6 mb-3">
                <label>Status</label>
                <select name="status" class="form-control">
                    <option value="active" @selected($item->status == 'active')>Active</option>
                    <option value="inactive" @selected($item->status == 'inactive')>Inactive</option>
                </select>
            </div>
            <div class="col-md-6 mb-3">
                <label>Phone</label>
                <input type="text" name="phone" value="{{ old('phone', $item->phone) }}" class="form-control">
            </div>
            <div class="col-md-6 mb-3">
                <label>Website</label>
                <input type="url" name="website" value="{{ old('website', $item->website) }}" class="form-control">
            </div>
            <div class="col-md-6 mb-3">
                <label>Location URL</label>
                <input type="url" name="location_url" value="{{ old('location_url', $item->location_url) }}" class="form-control">
            </div>
            <div class="col-md-6 mb-3">
                <label>Location Ordering</label>
                <input type="number" name="location_ordering" value="{{ old('location_ordering', $item->location_ordering) }}" class="form-control">
            </div>
            <div class="col-12 mb-3">
                <label>Address</label>
                <textarea name="address" class="form-control" rows="3">{{ old('address', $item->address) }}</textarea>
            </div>
            <div class="col-12 mb-3">
                <label>Description</label>
                <textarea name="description" class="form-control" rows="5">{{ old('description', $item->description) }}</textarea>
            </div>
        </div>
        <button type="submit" class="btn btn-primary">Update Hotel</button>
    </form>
</div>
@endsection
