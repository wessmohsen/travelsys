@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-start mb-3">
        <div>
            <h1>Edit Trip Program [ {{ $program->date ? $program->date->format('d-m-Y') : 'N/A' }} ]</h1>
            @include('partials.breadcrumbs', ['crumbs' => [
                ['href' => route('trip-programs.index'), 'text' => 'Trip Programs'],
                ['text' => 'Edit Trip Program']
            ]])
        </div>
        @can('view-trip-programs')
        <a href="{{ route('trip-programs.show', $program) }}" class="btn btn-primary">
            <i class="fas fa-eye"></i> View Trip Program
        </a>
        @endcan
    </div>

    <form method="POST" action="{{ route('trip-programs.update', $program->id) }}">
        @csrf
        @method('PUT')

        @include('trip_programs._form')

        <div class="mt-3">
            <button type="submit" class="btn btn-primary">Save Changes</button>
        </div>
    </form>
</div>
@endsection
