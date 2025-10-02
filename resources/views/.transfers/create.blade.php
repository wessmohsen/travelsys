@extends('layouts.app')
@section('content')
<div class="container-fluid">
    <h1>Add Transfer</h1>
    <form method="POST" action="{{ route('transfers.store') }}">
        @csrf
        <div class="mb-3">
            <label>From</label>
            <input type="text" name="from" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>To</label>
            <input type="text" name="to" class="form-control" required>
        </div>
        <button class="btn btn-success">Save</button>
    </form>
</div>
@endsection
