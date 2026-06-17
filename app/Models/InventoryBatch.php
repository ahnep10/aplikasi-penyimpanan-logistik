<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InventoryBatch extends Model
{
    protected $fillable = ['product_id', 'initial_quantity', 'current_quantity', 'batch_number', 'expiry_date', 'purchase_order_id', 'received_at'];

    protected $casts = [
        'expiry_date' => 'date',
        'received_at' => 'datetime',
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function purchase_order(): BelongsTo
    {
        return $this->belongsTo(PurchaseOrder::class);
    }
}
