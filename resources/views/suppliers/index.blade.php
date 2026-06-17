<x-app-layout>
    <div class="container py-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1>Suppliers</h1>
            <a href="{{ route('suppliers.create') }}" class="btn btn-primary">Add New Supplier</a>
        </div>

        <div class="card">
            <div class="card-body">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Contact Person</th>
                            <th>Phone</th>
                            <th>Email</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($suppliers as $supplier)
                            <tr>
                                <td>{{ $supplier->name }}</td>
                                <td>{{ $supplier->contact_person }}</td>
                                <td>{{ $supplier->phone }}</td>
                                <td>{{ $supplier->email }}</td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('suppliers.show', $supplier) }}" class="btn btn-sm btn-info">Show</a>
                                        <a href="{{ route('suppliers.edit', $supplier) }}" class="btn btn-sm btn-warning">Edit</a>
                                        <form action="{{ route('suppliers.destroy', $supplier) }}" method="POST" onsubmit="return confirm('Are you sure?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                {{ $suppliers->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
