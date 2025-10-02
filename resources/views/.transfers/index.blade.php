@extends('layouts.app')
@section('content')
<div class="container-fluid">
    <h1>Transfers</h1>
    <a href="{{ route('transfers.create') }}" class="btn btn-success mb-3">+ Add Transfer</a>
    <table class="table table-bordered">
        <thead><tr><th>ID</th><th>From</th><th>To</th><th>Actions</th></tr></thead>
        <tbody>
        @foreach($items as $item)
            <tr>
                <td>{{ $item->id }}</td>
                <td>{{ $item->from }}</td>
                <td>{{ $item->to }}</td>
                <td>
                    <a href="{{ route('transfers.edit',$item->id) }}" class="btn btn-sm btn-primary">Edit</a>
                    <form method="POST" action="{{ route('transfers.destroy',$item->id) }}" style="display:inline-block;">
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
