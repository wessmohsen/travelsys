@extends('layouts.app')
@section('content')
<div class="container-fluid">
    <h1>Edit Boat</h1>
    <form method="POST" action="{{ route('boats.update',$item->id) }}">
        @csrf @method('PUT')
        <div class="mb-3">
            <label>Name</label>
            <input type="text" name="name" value="{{ $item->name }}" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Capacity</label>
            <input type="number" name="capacity" value="{{ $item->capacity }}" class="form-control">
        </div>
        <button class="btn btn-success">Update</button>
    </form>
</div>
@endsection
