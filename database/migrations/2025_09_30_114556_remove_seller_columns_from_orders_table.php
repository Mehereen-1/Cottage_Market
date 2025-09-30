<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            // First drop the foreign key
            $table->dropForeign(['seller_id']);

            // Then drop the columns
            $table->dropColumn(['seller_id', 'admin_commission', 'net_amount']);
        });
    }

    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->unsignedBigInteger('seller_id')->nullable();
            $table->decimal('admin_commission', 10, 2)->default(0);
            $table->decimal('net_amount', 10, 2)->default(0);

            // Restore the foreign key
            $table->foreign('seller_id')->references('id')->on('users')->onDelete('cascade');
        });
    }
};
