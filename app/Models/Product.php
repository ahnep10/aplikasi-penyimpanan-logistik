<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    protected $fillable = ['sku', 'name', 'unit', 'safety_stock'];

    public function inventory_batches(): HasMany
    {
        return $this->hasMany(InventoryBatch::class);
    }

    public function inventory_movements(): HasMany
    {
        return $this->hasMany(InventoryMovement::class);
    }

    public function purchase_order_items(): HasMany
    {
        return $this->hasMany(PurchaseOrderItem::class);
    }

    public function getCurrentStockAttribute(): int
    {
        return $this->inventory_batches()->sum('current_quantity');
    }
}
