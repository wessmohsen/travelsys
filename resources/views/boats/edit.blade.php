@extends('layouts.app')
@section('content')
<div class="container-fluid">
    <h1>Edit Boat</h1>
    <form method="POST" action="{{ route('boats.update', $boat->id) }}">
        @csrf @method('PUT')
        <div class="mb-3">
            <label>Name</label>
            <input type="text" name="name" value="{{ $boat->name }}" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Capacity</label>
            <input type="number" name="capacity" value="{{ $boat->capacity }}" class="form-control">
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea name="description" id="description" class="form-control" rows="3">{{ old('description', $boat->description) }}</textarea>
        </div>
        <button class="btn btn-success">Update</button>
    </form>
</div>
@endsection
