@extends('layouts.app')
@section('content')
<div class="container-fluid">
    <h1>Add Boat</h1>
    <form method="POST" action="{{ route('boats.store') }}">
        @csrf
        <div class="mb-3">
            <label>Name</label>
            <input type="text" name="name" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Capacity</label>
            <input type="number" name="capacity" class="form-control">
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea name="description" id="description" class="form-control" rows="3">{{ old('description') }}</textarea>
        </div>
        <button class="btn btn-success">Save</button>
    </form>
</div>
@endsection
