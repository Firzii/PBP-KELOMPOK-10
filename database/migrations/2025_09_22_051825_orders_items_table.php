<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('product_id')->constrained()->cascadeOnUpdate()->restrictOnDelete();
            $table->decimal('price', 12, 2);      
            $table->unsignedInteger('qty');
            $table->decimal('subtotal', 12, 2);   
            $table->timestamps();

            $table->index('product_id');
        });
    }
    public function down(): void {
        Schema::dropIfExists('order_items');
    }
};
