<x-app-layout>
    <x-slot name="header">
        <h2 class="h4 font-weight-bold">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="row">
        <div class="col-md-3 mb-4">
            <div class="card bg-primary text-white shadow">
                <div class="card-body">
                    <h5 class="card-title">Products</h5>
                    <p class="card-text h2">{{ $stats['products_count'] }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-4">
            <div class="card bg-success text-white shadow">
                <div class="card-body">
                    <h5 class="card-title">Suppliers</h5>
                    <p class="card-text h2">{{ $stats['suppliers_count'] }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-4">
            <div class="card bg-warning text-dark shadow">
                <div class="card-body">
                    <h5 class="card-title">Pending POs</h5>
                    <p class="card-text h2">{{ $stats['pending_pos'] }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-4">
            <div class="card bg-danger text-white shadow">
                <div class="card-body">
                    <h5 class="card-title">Low Stock</h5>
                    <p class="card-text h2">{{ $stats['low_stock_products'] }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-md-6">
            <div class="card shadow">
                <div class="card-header bg-white">
                    <h5 class="mb-0">Quick Actions</h5>
                </div>
                <div class="card-body">
                    <div class="list-group">
                        @if(auth()->user()->hasRole('Admin') || auth()->user()->hasRole('Procurement Officer'))
                            <a href="{{ route('purchase-orders.create') }}" class="list-group-item list-group-item-action">Create Purchase Order</a>
                        @endif
                        @if(auth()->user()->hasRole('Admin') || auth()->user()->hasRole('Warehouse Staff'))
                            <a href="{{ route('products.index') }}" class="list-group-item list-group-item-action">Check Inventory</a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card shadow">
                <div class="card-header bg-white">
                    <h5 class="mb-0">System Info</h5>
                </div>
                <div class="card-body">
                    <p>Welcome back, <strong>{{ auth()->user()->name }}</strong>!</p>
                    <p>Your current role is: <span class="badge bg-secondary">{{ auth()->user()->role->name }}</span></p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
