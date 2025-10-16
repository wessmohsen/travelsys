@extends('layouts.app')
@section('content')
<div class="container-fluid">
    <h1>Add Trip</h1>
    <form method="POST" action="{{ route('trips.store') }}">
        @csrf
        <div class="mb-3">
            <label>Name</label>
            <input type="text" name="name" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Location</label>
            <input type="text" name="location" class="form-control">
        </div>
        <div class="mb-3">
            <label>Date</label>
            <input type="date" name="date" class="form-control">
        </div>
        <div class="mb-3">
            <label>Price</label>
            <input type="number" step="0.01" name="price" class="form-control">
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea name="description" id="description" class="form-control" rows="3">{{ old('description') }}</textarea>
        </div>
        <button class="btn btn-success">Save</button>
    </form>
</div>
@endsection
