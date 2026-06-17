<x-app-layout>
    <div class="container py-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1>Product Details: {{ $product->name }}</h1>
            <div>
                <a href="{{ route('products.edit', $product) }}" class="btn btn-warning">Edit</a>
                <a href="{{ route('products.index') }}" class="btn btn-secondary">Back to List</a>
            </div>
        </div>

        <div class="row mb-4">
            <div class="col-md-6">
                <div class="card h-100">
                    <div class="card-header">Basic Information</div>
                    <div class="card-body">
                        <table class="table table-borderless">
                            <tr>
                                <th>SKU:</th>
                                <td>{{ $product->sku }}</td>
                            </tr>
                            <tr>
                                <th>Name:</th>
                                <td>{{ $product->name }}</td>
                            </tr>
                            <tr>
                                <th>Unit:</th>
                                <td>{{ $product->unit }}</td>
                            </tr>
                            <tr>
                                <th>Safety Stock:</th>
                                <td>{{ $product->safety_stock }}</td>
                            </tr>
                            <tr>
                                <th>Current Stock:</th>
                                <td>
                                    <span class="badge {{ $product->current_stock <= $product->safety_stock ? 'bg-danger' : 'bg-success' }}">
                                        {{ $product->current_stock }}
                                    </span>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-header">Inventory Batches</div>
            <div class="card-body">
                <table class="table table-sm table-striped">
                    <thead>
                        <tr>
                            <th>Batch #</th>
                            <th>Quantity</th>
                            <th>Expiry Date</th>
                            <th>Received At</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($product->inventory_batches as $batch)
                            <tr>
                                <td>{{ $batch->batch_number }}</td>
                                <td>{{ $batch->current_quantity }}</td>
                                <td>{{ $batch->expiry_date ? $batch->expiry_date->format('Y-m-d') : 'N/A' }}</td>
                                <td>{{ $batch->created_at->format('Y-m-d H:i') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center">No active batches found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="card">
            <div class="card-header">Inventory Movements</div>
            <div class="card-body">
                <table class="table table-sm table-striped">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Type</th>
                            <th>Quantity</th>
                            <th>User</th>
                            <th>Remarks</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($product->inventory_movements as $movement)
                            <tr>
                                <td>{{ $movement->created_at->format('Y-m-d H:i') }}</td>
                                <td>
                                    <span class="badge {{ $movement->quantity > 0 ? 'bg-success' : 'bg-danger' }}">
                                        {{ str_replace('_', ' ', strtoupper($movement->type)) }}
                                    </span>
                                </td>
                                <td>{{ $movement->quantity }}</td>
                                <td>{{ $movement->user->name ?? 'System' }}</td>
                                <td>{{ $movement->remarks }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center">No movements recorded yet.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
