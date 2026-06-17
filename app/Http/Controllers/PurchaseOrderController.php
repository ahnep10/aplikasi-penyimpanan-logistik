<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\PurchaseOrder;
use App\Models\PurchaseOrderItem;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PurchaseOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $purchase_orders = PurchaseOrder::with(['supplier', 'creator'])->latest()->paginate(15);
        return view('purchase_orders.index', compact('purchase_orders'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $suppliers = Supplier::all();
        $products = Product::all();
        return view('purchase_orders.create', compact('suppliers', 'products'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'supplier_id' => 'required|exists:suppliers,id',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.unit_price' => 'required|numeric|min:0',
        ]);

        DB::transaction(function () use ($validated) {
            $po = PurchaseOrder::create([
                'po_number' => 'PO-' . time(),
                'supplier_id' => $validated['supplier_id'],
                'status' => 'draft',
                'created_by' => auth()->id(),
                'total_amount' => collect($validated['items'])->sum(fn($item) => $item['quantity'] * $item['unit_price']),
            ]);

            foreach ($validated['items'] as $item) {
                PurchaseOrderItem::create([
                    'purchase_order_id' => $po->id,
                    'product_id' => $item['product_id'],
                    'quantity' => $item['quantity'],
                    'unit_price' => $item['unit_price'],
                ]);
            }
        });

        return redirect()->route('purchase-orders.index')->with('success', 'Purchase order created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(PurchaseOrder $purchaseOrder)
    {
        $purchaseOrder->load(['supplier', 'creator', 'items.product']);
        return view('purchase_orders.show', compact('purchaseOrder'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PurchaseOrder $purchaseOrder)
    {
        if ($purchaseOrder->status !== 'draft') {
            return back()->with('error', 'Only draft purchase orders can be edited.');
        }

        $suppliers = Supplier::all();
        $products = Product::all();
        $purchaseOrder->load('items');

        return view('purchase_orders.edit', compact('purchaseOrder', 'suppliers', 'products'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PurchaseOrder $purchaseOrder)
    {
        if ($purchaseOrder->status !== 'draft') {
            return back()->with('error', 'Only draft purchase orders can be edited.');
        }

        $validated = $request->validate([
            'supplier_id' => 'required|exists:suppliers,id',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.unit_price' => 'required|numeric|min:0',
        ]);

        DB::transaction(function () use ($validated, $purchaseOrder) {
            $purchaseOrder->update([
                'supplier_id' => $validated['supplier_id'],
                'total_amount' => collect($validated['items'])->sum(fn($item) => $item['quantity'] * $item['unit_price']),
            ]);

            $purchaseOrder->items()->delete();

            foreach ($validated['items'] as $item) {
                PurchaseOrderItem::create([
                    'purchase_order_id' => $purchaseOrder->id,
                    'product_id' => $item['product_id'],
                    'quantity' => $item['quantity'],
                    'unit_price' => $item['unit_price'],
                ]);
            }
        });

        return redirect()->route('purchase-orders.index')->with('success', 'Purchase order updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PurchaseOrder $purchaseOrder)
    {
        if ($purchaseOrder->status !== 'draft') {
            return back()->with('error', 'Only draft purchase orders can be deleted.');
        }

        $purchaseOrder->delete();

        return redirect()->route('purchase-orders.index')->with('success', 'Purchase order deleted successfully.');
    }

    public function updateStatus(Request $request, PurchaseOrder $purchaseOrder)
    {
        $validated = $request->validate([
            'status' => 'required|in:ordered,cancelled',
        ]);

        if ($purchaseOrder->status !== 'draft') {
            return back()->with('error', 'Only draft purchase orders can be updated to ordered/cancelled.');
        }

        $data = ['status' => $validated['status']];
        if ($validated['status'] === 'ordered') {
            $data['ordered_at'] = now();
        }

        $purchaseOrder->update($data);

        return back()->with('success', 'Purchase order status updated to ' . $validated['status'] . '.');
    }
}
