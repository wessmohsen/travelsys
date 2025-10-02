@extends('layouts.app')
@section('content')
<div class="container-fluid">
    <h1>Add Vehicle</h1>
    <form method="POST" action="{{ route('vehicles.store') }}">
        @csrf
        <div class="mb-3">
            <label>Plate Number</label>
            <input type="text" name="plate_number" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Type</label>
            <input type="text" name="type" class="form-control">
        </div>
        <button class="btn btn-success">Save</button>
    </form>
</div>
@endsection
