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
        Schema::table('orders', function (Blueprint $table) {
            $table->foreignId('seller_id')->nullable()->after('user_id')->constrained('users')->onDelete('cascade');
            $table->decimal('admin_commission',10,2)->default(0)->after('total_amount');
            $table->decimal('net_amount',10,2)->default(0)->after('admin_commission');
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropForeign(['seller_id']);
            $table->dropColumn(['seller_id','admin_commission','net_amount']);
        });
    }

};
