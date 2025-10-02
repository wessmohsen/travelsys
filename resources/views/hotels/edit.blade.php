@extends('layouts.app')
@section('content')
<div class="container-fluid">
    <h1>Edit Hotel</h1>
    <form method="POST" action="{{ route('hotels.update',$item->id) }}">
        @csrf @method('PUT')
        <div class="mb-3">
            <label>Name</label>
            <input type="text" name="name" value="{{ $item->name }}" class="form-control" required>
        </div>
        <button class="btn btn-success">Update</button>
    </form>
</div>
@endsection
