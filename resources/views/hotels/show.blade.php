@extends('layouts.app')
@section('title','Hotel Details')
@section('page_title','Hotel Details')

@section('content')
<div class="card">
  <div class="card-body">
    <dl class="row">
      <dt class="col-sm-3">ID</dt>
      <dd class="col-sm-9">{{ $hotel->id }}</dd>

      <dt class="col-sm-3">Name</dt>
      <dd class="col-sm-9">{{ $hotel->name }}</dd>

      <dt class="col-sm-3">Description</dt>
      <dd class="col-sm-9">{{ $hotel->description }}</dd>

      <dt class="col-sm-3">Created At</dt>
      <dd class="col-sm-9">{{ $hotel->created_at->format('Y-m-d') }}</dd>
    </dl>
    <a href="{{ route('hotels.index') }}" class="btn btn-secondary">Back</a>
  </div>
</div>
@endsection
