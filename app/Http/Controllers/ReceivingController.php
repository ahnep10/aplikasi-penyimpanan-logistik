<?php

namespace App\Http\Controllers;

use App\Models\InventoryBatch;
use App\Models\InventoryMovement;
use App\Models\PurchaseOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReceivingController extends Controller
{
    public function show(PurchaseOrder $purchase_order)
    {
        if ($purchase_order->status !== 'ordered') {
            return back()->with('error', 'Only ordered purchase orders can be received.');
        }

        $purchase_order->load('items.product');
        return view('purchase_orders.receive', compact('purchase_order'));
    }

    public function store(Request $request, PurchaseOrder $purchase_order)
    {
        if ($purchase_order->status !== 'ordered') {
            return back()->with('error', 'Only ordered purchase orders can be received.');
        }

        $validated = $request->validate([
            'items' => 'required|array',
            'items.*.id' => 'required|exists:purchase_order_items,id',
            'items.*.received_quantity' => 'required|integer|min:0',
            'items.*.batch_number' => 'nullable|string|max:255',
            'items.*.expiry_date' => 'nullable|date',
        ]);

        DB::transaction(function () use ($validated, $purchase_order) {
            foreach ($validated['items'] as $itemData) {
                $poItem = $purchase_order->items()->find($itemData['id']);
                
                if ($itemData['received_quantity'] > 0) {
                    $poItem->update([
                        'received_quantity' => $poItem->received_quantity + $itemData['received_quantity']
                    ]);

                    // Create Inventory Batch
                    InventoryBatch::create([
                        'product_id' => $poItem->product_id,
                        'initial_quantity' => $itemData['received_quantity'],
                        'current_quantity' => $itemData['received_quantity'],
                        'batch_number' => $itemData['batch_number'],
                        'expiry_date' => $itemData['expiry_date'],
                        'purchase_order_id' => $purchase_order->id,
                        'received_at' => now(),
                    ]);

                    // Record Movement
                    InventoryMovement::create([
                        'product_id' => $poItem->product_id,
                        'quantity' => $itemData['received_quantity'],
                        'type' => 'purchase_receipt',
                        'reference_type' => 'PurchaseOrder',
                        'reference_id' => $purchase_order->id,
                        'user_id' => auth()->id(),
                        'remarks' => 'Received from PO #' . $purchase_order->po_number,
                    ]);
                }
            }

            // Check if fully received
            $isFullyReceived = $purchase_order->items->every(fn($item) => $item->received_quantity >= $item->quantity);
            if ($isFullyReceived) {
                $purchase_order->update([
                    'status' => 'received',
                    'received_at' => now()
                ]);
            }
        });

        return redirect()->route('purchase-orders.show', $purchase_order)->with('success', 'Goods received and inventory updated.');
    }
}
