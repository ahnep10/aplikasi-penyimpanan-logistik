<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('inventory_movements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained('products');
            $table->integer('quantity'); // Positive for inbound, negative for outbound
            $table->string('type'); // purchase_receipt, sale_fulfillment, adjustment, return
            $table->string('reference_type')->nullable(); // e.g., PurchaseOrder
            $table->unsignedBigInteger('reference_id')->nullable();
            $table->foreignId('user_id')->constrained('users');
            $table->text('remarks')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventory_movements');
    }
};
