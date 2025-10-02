@extends('layouts.app')
@section('content')
<div class="container-fluid">
    <h1>Add Driver</h1>
    <form method="POST" action="{{ route('drivers.store') }}">
        @csrf
        <div class="mb-3">
            <label>Name</label>
            <input type="text" name="name" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>License Number</label>
            <input type="text" name="license_number" class="form-control">
        </div>
        <button class="btn btn-success">Save</button>
    </form>
</div>
@endsection
