<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnUpdate()->restrictOnDelete();
            $table->decimal('total', 12, 2)->default(0);
            // status: diproses, dikirim, selesai, batal
            $table->string('status')->default('diproses');
            $table->text('address_text');
            $table->timestamps();

            $table->index(['status','created_at']);
        });
    }
    public function down(): void {
        Schema::dropIfExists('orders');
    }
};
