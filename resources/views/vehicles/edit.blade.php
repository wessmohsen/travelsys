@extends('layouts.app')
@section('content')
<div class="container-fluid">
    <h1>Edit Vehicle</h1>
    <form method="POST" action="{{ route('vehicles.update',$item->id) }}">
        @csrf @method('PUT')
        <div class="mb-3">
            <label>Plate Number</label>
            <input type="text" name="plate_number" value="{{ $item->plate_number }}" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Type</label>
            <input type="text" name="type" value="{{ $item->type }}" class="form-control">
        </div>
        <button class="btn btn-success">Update</button>
    </form>
</div>
@endsection
