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
        $table->foreignId('user_id')->constrained()->onDelete('cascade'); // buyer
        $table->enum('status',['pending','paid','shipped','completed','cancelled'])->default('pending');
        $table->decimal('total_amount',10,2);
        $table->enum('payment_status',['unpaid','paid','failed'])->default('unpaid');
        $table->string('payment_method')->nullable(); // 'bkash', 'cash'
        $table->string('transaction_id')->nullable(); // from bkash
        $table->text('shipping_address')->nullable();
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
