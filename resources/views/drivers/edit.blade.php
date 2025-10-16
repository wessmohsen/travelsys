@extends('layouts.app')
@section('content')
<div class="container-fluid">
    <h1>Edit Driver</h1>
    @include('partials.breadcrumbs', ['crumbs' => [
        ['href' => route('drivers.index'), 'text' => 'Drivers'],
        ['text' => 'Edit Driver']
    ]])
    <form method="POST" action="{{ route('drivers.update', $item->id) }}">
        @csrf
        @method('PUT')
        <div class="row">
            <div class="col-md-6 mb-3">
                <label>Name</label>
                <input type="text" name="name" value="{{ old('name', $item->name) }}" class="form-control" required>
            </div>
            <div class="col-md-6 mb-3">
                <label>Email</label>
                <input type="email" name="email" value="{{ old('email', $item->email) }}" class="form-control">
            </div>
            <div class="col-md-6 mb-3">
                <label>License Number</label>
                <input type="text" name="license_number" value="{{ old('license_number', $item->license_number) }}" class="form-control">
            </div>
            <div class="col-md-6 mb-3">
                <label>Phone Number</label>
                <input type="text" name="phone" value="{{ old('phone', $item->phone) }}" class="form-control">
            </div>
            <div class="col-md-6 mb-3">
                <label>Alternative Phone</label>
                <input type="text" name="alternative_phone" value="{{ old('alternative_phone', $item->alternative_phone) }}" class="form-control">
            </div>
            <div class="col-12 mb-3">
                <label>Address</label>
                <textarea name="address" class="form-control" rows="3">{{ old('address', $item->address) }}</textarea>
            </div>
        </div>
        <button type="submit" class="btn btn-primary">Update Driver</button>
    </form>
</div>
@endsection
