@extends('layouts.app')
@section('title','Edit Daily Program')

@section('content')
<form method="post" action="{{ route('trip-programs.update',$program) }}">
    @csrf @method('PUT')
    @include('trip_programs._form')
    <br>
    <button class="btn btn-primary">Update Program</button>
    <a class="btn" href="{{ route('trip-programs.index') }}">Cancel</a>
</form>
@endsection
