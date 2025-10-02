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
        <button class="btn btn-success">Save</button>
    </form>
</div>
@endsection
