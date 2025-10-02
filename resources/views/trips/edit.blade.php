@extends('layouts.app')
@section('content')
<div class="container-fluid">
    <h1>Edit Trip</h1>
    <form method="POST" action="{{ route('trips.update',$item->id) }}">
        @csrf @method('PUT')
        <div class="mb-3">
            <label>Name</label>
            <input type="text" name="name" value="{{ $item->name }}" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Location</label>
            <input type="text" name="location" value="{{ $item->location }}" class="form-control">
        </div>
        <div class="mb-3">
            <label>Date</label>
            <input type="date" name="date" value="{{ $item->date }}" class="form-control">
        </div>
        <div class="mb-3">
            <label>Price</label>
            <input type="number" step="0.01" name="price" value="{{ $item->price }}" class="form-control">
        </div>
        <button class="btn btn-success">Update</button>
    </form>
</div>
@endsection
