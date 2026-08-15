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
        $table->string('tracking_number')->unique();
        $table->string('customer_name');
        $table->string('customer_phone');
        $table->string('city');
        $table->text('address');
        $table->decimal('total_amount', 10, 2);
        $table->enum('status', [
            'nouveau', 
            'confirme', 
            'en_livraison', 
            'livre', 
            'annule', 
            'retour'
        ])->default('nouveau');
        $table->text('admin_notes')->nullable();
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
