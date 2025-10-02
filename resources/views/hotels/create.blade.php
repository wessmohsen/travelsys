@extends('layouts.app')
@section('content')
<div class="container-fluid">
    <h1>Add Hotel</h1>
    <form method="POST" action="{{ route('hotels.store') }}">
        @csrf
        <div class="mb-3">
            <label>Name</label>
            <input type="text" name="name" class="form-control" required>
        </div>
        <button class="btn btn-success">Save</button>
    </form>
</div>
@endsection
