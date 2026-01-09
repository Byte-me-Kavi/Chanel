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
        Schema::create('deliveries', function (Blueprint $table) {
            $table->id();
            $table->string('order_number');
            $table->string('item_name');
            $table->string('item_category');
            $table->string('delivery_code');
            $table->string('courier_id');
            $table->string('status');
            $table->string('customer_name');
            $table->text('address');
            $table->string('product');
            $table->integer('quantity');
            $table->timestamp('created_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('deliveries');
    }
};
