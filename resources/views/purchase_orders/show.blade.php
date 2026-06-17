<x-app-layout>
    <div class="container py-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1>Purchase Order: {{ $purchaseOrder->po_number }}</h1>
            <div>
                @if($purchaseOrder->status === 'draft')
                    <form action="{{ route('purchase-orders.update-status', $purchaseOrder) }}" method="POST" class="d-inline">
                        @csrf
                        @method('PATCH')
                        <input type="hidden" name="status" value="ordered">
                        <button type="submit" class="btn btn-primary">Mark as Ordered</button>
                    </form>
                    <a href="{{ route('purchase-orders.edit', $purchaseOrder) }}" class="btn btn-warning">Edit</a>
                @endif

                @if($purchaseOrder->status === 'ordered')
                    <a href="{{ route('purchase-orders.receive.show', $purchaseOrder) }}" class="btn btn-success">Receive Goods</a>
                @endif

                <a href="{{ route('purchase-orders.index') }}" class="btn btn-secondary">Back to List</a>
            </div>
        </div>

        <div class="row mb-4">
            <div class="col-md-6">
                <div class="card h-100">
                    <div class="card-header">General Information</div>
                    <div class="card-body">
                        <table class="table table-borderless mb-0">
                            <tr>
                                <th>Supplier:</th>
                                <td>{{ $purchaseOrder->supplier->name }}</td>
                            </tr>
                            <tr>
                                <th>Status:</th>
                                <td>
                                    @php
                                        $badgeClass = match($purchaseOrder->status) {
                                            'draft' => 'bg-secondary',
                                            'ordered' => 'bg-primary',
                                            'received' => 'bg-success',
                                            'cancelled' => 'bg-danger',
                                            default => 'bg-info'
                                        };
                                    @endphp
                                    <span class="badge {{ $badgeClass }}">{{ strtoupper($purchaseOrder->status) }}</span>
                                </td>
                            </tr>
                            <tr>
                                <th>Total Amount:</th>
                                <td>{{ number_format($purchaseOrder->total_amount, 2) }}</td>
                            </tr>
                            <tr>
                                <th>Created By:</th>
                                <td>{{ $purchaseOrder->creator->name }}</td>
                            </tr>
                            <tr>
                                <th>Date:</th>
                                <td>{{ $purchaseOrder->created_at->format('Y-m-d H:i') }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header">Order Items</div>
            <div class="card-body">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Quantity</th>
                            <th>Unit Price</th>
                            <th class="text-end">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($purchaseOrder->items as $item)
                            <tr>
                                <td>{{ $item->product->name }} ({{ $item->product->sku }})</td>
                                <td>{{ $item->quantity }}</td>
                                <td>{{ number_format($item->unit_price, 2) }}</td>
                                <td class="text-end">{{ number_format($item->quantity * $item->unit_price, 2) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th colspan="3" class="text-end">Total:</th>
                            <th class="text-end">{{ number_format($purchaseOrder->total_amount, 2) }}</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
