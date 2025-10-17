@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <h1>Edit Trip Program</h1>
    <form method="POST" action="{{ route('trip-programs.update', $program->id) }}">
        @csrf
        @method('PUT')

        @include('trip_programs._form')

        <div class="mt-3">
            <button type="submit" class="btn btn-primary">Save Changes</button>
            <a href="{{ route('trip-programs.index') }}" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
</div>
@endsection
