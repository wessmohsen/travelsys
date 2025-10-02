@extends('layouts.app')
@section('content')
<div class="container-fluid">
    <h1>Edit Guide</h1>
    <form method="POST" action="{{ route('guides.update',$item->id) }}">
        @csrf @method('PUT')
        <div class="mb-3">
            <label>Name</label>
            <input type="text" name="name" value="{{ $item->name }}" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Language</label>
            <input type="text" name="language" value="{{ $item->language }}" class="form-control">
        </div>
        <button class="btn btn-success">Update</button>
    </form>
</div>
@endsection
