@extends('layouts.app')
@section('content')
    <div class="container-fluid">
        <h1>Edit Diving Course</h1>
        <form method="POST" action="{{ route('diving-courses.update', $item->id) }}">
            @csrf @method('PUT')
            <div class="mb-3">
                <label>Title</label>
                <input type="text" name="title" value="{{ $item->title }}" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Description</label>
                <textarea name="description" class="form-control">{{ $item->description }}</textarea>
            </div>
            <div class="mb-3">
                <label>Price</label>
                <input type="number" step="0.01" name="price" value="{{ $item->price }}" class="form-control">
            </div>
            <button class="btn btn-success">Update</button>
        </form>


    </div>
@endsection
