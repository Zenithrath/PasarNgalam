<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('reviews', function (Blueprint $table) {
        $table->id();
        // Link ke Transaksi
        $table->foreignId('order_id')->constrained()->cascadeOnDelete();
        
        // Siapa yang memberi review (biasanya Customer)
        $table->foreignId('reviewer_id')->constrained('users');
        
        // Siapa yang direview (Bisa ID Merchant atau ID Driver)
        $table->foreignId('target_id')->constrained('users');
        
        $table->tinyInteger('rating'); // 1 sampai 5
        $table->text('comment')->nullable(); // Ulasan teks
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};
