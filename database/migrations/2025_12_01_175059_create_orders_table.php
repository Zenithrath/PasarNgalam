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
            $table->foreignId('customer_id')->constrained('users'); 
            $table->foreignId('merchant_id')->constrained('users'); 
            $table->foreignId('driver_id')->nullable()->constrained('users'); 

            $table->string('delivery_address');
            $table->decimal('total_price', 10, 2);
            $table->decimal('delivery_fee', 10, 2);
            $table->enum('status', ['pending', 'cooking', 'ready', 'delivery', 'completed'])->default('pending');

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
