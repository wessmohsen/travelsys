@extends('layouts.app')
@section('content')
<div class="container-fluid">
    <h1>Edit Transfer</h1>
    <form method="POST" action="{{ route('transfers.update',$item->id) }}">
        @csrf @method('PUT')
        <div class="mb-3">
            <label>From</label>
            <input type="text" name="from" value="{{ $item->from }}" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>To</label>
            <input type="text" name="to" value="{{ $item->to }}" class="form-control" required>
        </div>
        <button class="btn btn-success">Update</button>
    </form>
</div>
@endsection
