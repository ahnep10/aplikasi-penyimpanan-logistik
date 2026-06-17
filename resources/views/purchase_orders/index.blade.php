<x-app-layout>
    <div class="container py-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1>Purchase Orders</h1>
            <a href="{{ route('purchase-orders.create') }}" class="btn btn-primary">New Purchase Order</a>
        </div>

        <div class="card">
            <div class="card-body">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>PO #</th>
                            <th>Supplier</th>
                            <th>Status</th>
                            <th>Total Amount</th>
                            <th>Created By</th>
                            <th>Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($purchase_orders as $po)
                            <tr>
                                <td>{{ $po->po_number }}</td>
                                <td>{{ $po->supplier->name }}</td>
                                <td>
                                    @php
                                        $badgeClass = match($po->status) {
                                            'draft' => 'bg-secondary',
                                            'ordered' => 'bg-primary',
                                            'received' => 'bg-success',
                                            'cancelled' => 'bg-danger',
                                            default => 'bg-info'
                                        };
                                    @endphp
                                    <span class="badge {{ $badgeClass }}">{{ strtoupper($po->status) }}</span>
                                </td>
                                <td>{{ number_format($po->total_amount, 2) }}</td>
                                <td>{{ $po->creator->name }}</td>
                                <td>{{ $po->created_at->format('Y-m-d') }}</td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('purchase-orders.show', $po) }}" class="btn btn-sm btn-info">Show</a>
                                        @if($po->status === 'draft')
                                            <a href="{{ route('purchase-orders.edit', $po) }}" class="btn btn-sm btn-warning">Edit</a>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                {{ $purchase_orders->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
