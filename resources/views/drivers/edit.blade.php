@extends('layouts.app')
@section('content')
<div class="container-fluid">
    <h1>Edit Driver</h1>
    <form method="POST" action="{{ route('drivers.update',$item->id) }}">
        @csrf @method('PUT')
        <div class="mb-3">
            <label>Name</label>
            <input type="text" name="name" value="{{ $item->name }}" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>License Number</label>
            <input type="text" name="license_number" value="{{ $item->license_number }}" class="form-control">
        </div>
        <button class="btn btn-success">Update</button>
    </form>
</div>
@endsection
