<x-app-layout>
    <div class="container py-4">
        <div class="card">
            <div class="card-header">
                <h1 class="h3 mb-0">Receive Goods: {{ $purchase_order->po_number }}</h1>
            </div>
            <div class="card-body">
                <form action="{{ route('purchase-orders.receive.store', $purchase_order) }}" method="POST">
                    @csrf

                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th>Ordered Qty</th>
                                <th>Received Qty</th>
                                <th>Batch #</th>
                                <th>Expiry Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($purchase_order->items as $index => $item)
                                <tr>
                                    <td>
                                        {{ $item->product->name }} ({{ $item->product->sku }})
                                        <input type="hidden" name="items[{{ $index }}][id]" value="{{ $item->id }}">
                                    </td>
                                    <td>{{ $item->quantity }}</td>
                                    <td>
                                        <input type="number" name="items[{{ $index }}][received_quantity]" class="form-control" value="{{ $item->quantity - $item->received_quantity }}" min="0" required>
                                    </td>
                                    <td>
                                        <input type="text" name="items[{{ $index }}][batch_number]" class="form-control" placeholder="Optional">
                                    </td>
                                    <td>
                                        <input type="date" name="items[{{ $index }}][expiry_date]" class="form-control">
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <div class="d-flex justify-content-between mt-4">
                        <a href="{{ route('purchase-orders.show', $purchase_order) }}" class="btn btn-secondary">Cancel</a>
                        <button type="submit" class="btn btn-success">Complete Receipt</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
