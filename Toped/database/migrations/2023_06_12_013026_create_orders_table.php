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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('receiptId');
            $table->foreignId('user_id');
            $table->foreignId('product_id');
            $table->string('price');
            $table->string('quantity');
            $table->string('paymentMethod');
            $table->string('origin');
            $table->string('destination');
            $table->string('courier');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
