@extends('layouts.app')
@section('content')
<div class="container-fluid">
    <h1>Add Guide</h1>
    <form method="POST" action="{{ route('guides.store') }}">
        @csrf
        <div class="mb-3">
            <label>Name</label>
            <input type="text" name="name" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Language</label>
            <input type="text" name="language" class="form-control">
        </div>
        <button class="btn btn-success">Save</button>
    </form>
</div>
@endsection
