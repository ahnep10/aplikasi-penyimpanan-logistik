<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PurchaseOrderController;
use App\Http\Controllers\ReceivingController;
use App\Http\Controllers\SupplierController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('dashboard');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Inventory & Catalog
    Route::middleware('role:Admin,Manager,Warehouse Staff,Procurement Officer')->group(function () {
        Route::resource('products', ProductController::class);
    });

    // Suppliers
    Route::middleware('role:Admin,Manager,Procurement Officer')->group(function () {
        Route::resource('suppliers', SupplierController::class);
    });

    // Procurement
    Route::middleware('role:Admin,Manager,Procurement Officer')->group(function () {
        Route::resource('purchase-orders', PurchaseOrderController::class);
        Route::patch('purchase-orders/{purchase_order}/status', [PurchaseOrderController::class, 'updateStatus'])->name('purchase-orders.update-status');
    });

    // Receiving
    Route::middleware('role:Admin,Warehouse Staff')->group(function () {
        Route::get('purchase-orders/{purchase_order}/receive', [ReceivingController::class, 'show'])->name('purchase-orders.receive.show');
        Route::post('purchase-orders/{purchase_order}/receive', [ReceivingController::class, 'store'])->name('purchase-orders.receive.store');
    });
});

require __DIR__.'/auth.php';
