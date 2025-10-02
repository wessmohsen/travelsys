@extends('layouts.app')
@section('content')
<div class="container-fluid">
    <h1>Diving Courses</h1>
    <a href="{{ route('diving-courses.create') }}" class="btn btn-success mb-3">+ Add Course</a>
    <table class="table table-bordered">
        <thead>
<tr>
    <th>ID</th>
    <th>Title</th>
    <th>Description</th>
    <th>Price</th>
    <th>Actions</th>
</tr>
</thead>
<tbody>
@foreach($items as $item)
    <tr>
        <td>{{ $item->id }}</td>
        <td>{{ $item->title }}</td>
        <td>{{ $item->description }}</td>
        <td>{{ $item->price }}</td>
        <td>
            <a href="{{ route('diving-courses.edit',$item->id) }}" class="btn btn-sm btn-primary">Edit</a>
            <form method="POST" action="{{ route('diving-courses.destroy',$item->id) }}" style="display:inline-block;">
                @csrf @method('DELETE')
                <button class="btn btn-sm btn-danger">Delete</button>
            </form>
        </td>
    </tr>
@endforeach
</tbody>

    </table>
    {{ $items->links('pagination::bootstrap-5') }}
</div>
@endsection
