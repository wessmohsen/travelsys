@extends('layouts.app')
@section('content')
<div class="container-fluid">
    <h1>Add Diving Course</h1>
    <form method="POST" action="{{ route('diving-courses.store') }}">
        @csrf
        <div class="mb-3">
            <label>Name</label>
            <input type="text" name="name" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Level</label>
            <input type="text" name="level" class="form-control">
        </div>
        <button class="btn btn-success">Save</button>
    </form>
</div>
@endsection
