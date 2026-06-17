<x-app-layout>
    <div class="container py-4">
        <div class="card">
            <div class="card-header">
                <h1 class="h3 mb-0">New Purchase Order</h1>
            </div>
            <div class="card-body">
                <form action="{{ route('purchase-orders.store') }}" method="POST" id="po-form">
                    @csrf

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <label for="supplier_id" class="form-label">Supplier</label>
                            <select name="supplier_id" id="supplier_id" class="form-select @error('supplier_id') is-invalid @enderror" required>
                                <option value="">Select Supplier</option>
                                @foreach($suppliers as $supplier)
                                    <option value="{{ $supplier->id }}" {{ old('supplier_id') == $supplier->id ? 'selected' : '' }}>
                                        {{ $supplier->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('supplier_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <h4 class="mb-3">Items</h4>
                    <table class="table table-bordered" id="items-table">
                        <thead>
                            <tr>
                                <th style="width: 50%;">Product</th>
                                <th>Quantity</th>
                                <th>Unit Price</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(old('items'))
                                @foreach(old('items') as $index => $item)
                                    <tr>
                                        <td>
                                            <select name="items[{{ $index }}][product_id]" class="form-select" required>
                                                <option value="">Select Product</option>
                                                @foreach($products as $product)
                                                    <option value="{{ $product->id }}" {{ $item['product_id'] == $product->id ? 'selected' : '' }}>
                                                        {{ $product->name }} ({{ $product->sku }})
                                                    </option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td>
                                            <input type="number" name="items[{{ $index }}][quantity]" class="form-control" value="{{ $item['quantity'] }}" min="1" required>
                                        </td>
                                        <td>
                                            <input type="number" name="items[{{ $index }}][unit_price]" class="form-control" value="{{ $item['unit_price'] }}" step="0.01" min="0" required>
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-danger remove-row">Remove</button>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td>
                                        <select name="items[0][product_id]" class="form-select" required>
                                            <option value="">Select Product</option>
                                            @foreach($products as $product)
                                                <option value="{{ $product->id }}">
                                                    {{ $product->name }} ({{ $product->sku }})
                                                </option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td>
                                        <input type="number" name="items[0][quantity]" class="form-control" min="1" required>
                                    </td>
                                    <td>
                                        <input type="number" name="items[0][unit_price]" class="form-control" step="0.01" min="0" required>
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-danger remove-row">Remove</button>
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                    </table>

                    <div class="mb-4">
                        <button type="button" class="btn btn-success" id="add-row">Add Item</button>
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('purchase-orders.index') }}" class="btn btn-secondary">Cancel</a>
                        <button type="submit" class="btn btn-primary">Create Purchase Order</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const table = document.getElementById('items-table').getElementsByTagName('tbody')[0];
            const addRowBtn = document.getElementById('add-row');
            let rowCount = table.rows.length;

            addRowBtn.addEventListener('click', function() {
                const newRow = table.rows[0].cloneNode(true);
                const inputs = newRow.getElementsByTagName('input');
                const selects = newRow.getElementsByTagName('select');

                for (let input of inputs) {
                    input.value = '';
                    input.name = input.name.replace(/\[\d+\]/, `[${rowCount}]`);
                }

                for (let select of selects) {
                    select.selectedIndex = 0;
                    select.name = select.name.replace(/\[\d+\]/, `[${rowCount}]`);
                }

                table.appendChild(newRow);
                rowCount++;
            });

            table.addEventListener('click', function(e) {
                if (e.target.classList.contains('remove-row')) {
                    if (table.rows.length > 1) {
                        e.target.closest('tr').remove();
                    } else {
                        alert('At least one item is required.');
                    }
                }
            });
        });
    </script>
    @endpush
</x-app-layout>
