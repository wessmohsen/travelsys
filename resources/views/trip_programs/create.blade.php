@extends('layouts.app')
@section('title','New Daily Program')

@section('content')
<form method="post" action="{{ route('trip-programs.store') }}">
    @csrf
    @include('trip_programs._form')
    <br>
    <button class="btn btn-primary">Save Program</button>
    <a class="btn" href="{{ route('trip-programs.index') }}">Cancel</a>
</form>
@endsection
