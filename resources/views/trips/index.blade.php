@extends('layouts.app')
@section('content')
<div class="container-fluid">
    <h1>Trips</h1>
    @include('partials.breadcrumbs', ['crumbs' => [
        ['text' => 'Trips']
    ]])
    <a href="{{ route('trips.create') }}" class="btn btn-success mb-3">+ Add Trip</a>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Location</th>
                <th>Price</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        @foreach($items as $item)
            <tr>
                <td>{{ $item->id }}</td>
                <td>{{ $item->name }}</td>
                <td>{{ $item->location }}</td>
                <td>{{ $item->price }}</td>
                <td>
                    <a href="{{ route('trips.edit',$item->id) }}" class="btn btn-sm btn-primary">Edit</a>
                    <form method="POST" action="{{ route('trips.destroy',$item->id) }}" class="delete-form" style="display:inline">
                        @csrf @method('DELETE')
                        <button type="button" class="btn btn-sm btn-danger delete-btn">Delete</button>
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    {{ $items->links('pagination::bootstrap-5') }}

    <!-- Bootstrap Delete Confirmation Modal -->
    <div class="modal fade" id="deleteConfirmModal" tabindex="-1" aria-labelledby="deleteConfirmModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header" style="border-bottom: 1px solid #dee2e6; padding: 12px 16px;">
                    <h5 class="modal-title" id="deleteConfirmModalLabel" style="font-size: 0.95rem; font-weight: 500;">
                        Confirm Delete
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="font-size: 0.8rem;"></button>
                </div>
                <div class="modal-body" style="padding: 20px;">
                    <p style="margin-bottom: 0; font-size: 0.95rem;">Are you sure you want to delete this trip?</p>
                </div>
                <div class="modal-footer" style="border-top: 1px solid #dee2e6; padding: 12px 16px; gap: 8px;">
                    <button type="button" class="btn btn-primary" id="confirmDeleteBtn" style="min-width: 80px;">OK</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" style="min-width: 80px;">Cancel</button>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var formToSubmit = null;

        // Handle Delete button click - Show modal
        document.querySelectorAll('.delete-btn').forEach(function(button) {
            button.addEventListener('click', function() {
                formToSubmit = this.closest('.delete-form');
                var deleteModal = new bootstrap.Modal(document.getElementById('deleteConfirmModal'));
                deleteModal.show();
            });
        });

        // Handle OK button in modal
        document.getElementById('confirmDeleteBtn').addEventListener('click', function() {
            if (formToSubmit) {
                formToSubmit.submit();
            }
            var deleteModal = bootstrap.Modal.getInstance(document.getElementById('deleteConfirmModal'));
            deleteModal.hide();
        });
    });
</script>
@endpush
@endsection
