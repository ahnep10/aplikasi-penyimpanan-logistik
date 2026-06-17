<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\PurchaseOrder;
use App\Models\Supplier;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'products_count' => Product::count(),
            'suppliers_count' => Supplier::count(),
            'pending_pos' => PurchaseOrder::whereIn('status', ['draft', 'ordered'])->count(),
            'low_stock_products' => Product::withSum('inventory_batches as stock', 'current_quantity')
                ->get()
                ->filter(fn($p) => $p->stock <= $p->safety_stock)
                ->count(),
        ];

        return view('dashboard', compact('stats'));
    }
}
