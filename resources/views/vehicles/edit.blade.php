@extends('layouts.app')
@section('content')
<div class="container-fluid">
    <h1>Edit Vehicle</h1>
    @include('partials.breadcrumbs', ['crumbs' => [
        ['href' => route('vehicles.index'), 'text' => 'Vehicles'],
        ['text' => 'Edit Vehicle']
    ]])
    <form method="POST" action="{{ route('vehicles.update',$item->id) }}">
        @csrf @method('PUT')
        <div class="mb-3">
            <label>Plate Number</label>
            <input type="text" name="plate_number" value="{{ $item->plate_number }}" class="form-control" required>
        </div>
        <div class="col-md-6 mb-3">
            <label>Type</label>
            <input type="text" name="type" value="{{ old('type', $item->type) }}" class="form-control" required>
        </div>
        <div class="col-md-6 mb-3">
            <label>Capacity</label>
            <input type="number" name="capacity" value="{{ old('capacity', $item->capacity) }}" class="form-control" min="1">
        </div>
        <button class="btn btn-success">Update</button>
    </form>
</div>
@endsection
