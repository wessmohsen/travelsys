<div class="family-members-wrapper">
    <h5 class="mb-3">Family Members</h5>

    @if(isset($item->subCustomers) && $item->subCustomers->count() > 0)
        <table class="table table-bordered table-striped align-middle">
            <thead class="table-light">
                <tr>
                    <th>Name</th>
                    <th>Type</th>
                    <th>Date of Birth</th>
                    <th>Gender</th>
                    <th>Responsible Adult</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($item->subCustomers as $sub)
                    <tr>
                        <td>{{ $sub->first_name }} {{ $sub->last_name }}</td>
                        <td>{{ ucfirst($sub->type) }}</td>
                        <td>{{ $sub->dob ? \Carbon\Carbon::parse($sub->dob)->format('d M Y') : '-' }}</td>
                        <td>{{ ucfirst($sub->gender ?? '-') }}</td>
                        <td>{{ $sub->responsible_name ?? '-' }}</td>
                        <td>
                            <a href="{{ route('customers.subcustomers.update', ['customer' => $item->id, 'subcustomer' => $sub->id]) }}" class="btn btn-sm btn-warning">Edit</a>
                            <form method="POST" action="{{ route('customers.subcustomers.update', ['customer' => $item->id, 'subcustomer' => $sub->id]) }}">
                                @csrf
                                @method('PUT')
                                <!-- Form fields for subcustomer -->
                            </form>
                            <form action="{{ route('subcustomers.destroy', $sub->id) }}" method="POST" style="display:inline-block;">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-danger" onclick="return confirm('Delete this family member?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p class="text-muted">No family members found for this customer.</p>
    @endif

    <a href="{{ route('subcustomers.create', ['customer_id' => $item->id]) }}" class="btn btn-primary mt-3">
        <i class="fa fa-plus"></i> Add Family Member
    </a>
</div>
