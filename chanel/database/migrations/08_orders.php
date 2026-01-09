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
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->string('product_name');
            $table->decimal('price', 10, 2);
            $table->string('image')->nullable();
            $table->integer('quantity')->default(1);
            $table->string('order_status')->default('pending');
            $table->string('status')->nullable();
            $table->boolean('wrapping_option')->default(false);
            $table->text('gift_message')->nullable();
            $table->boolean('samples')->default(false);
            $table->timestamp('order_date')->useCurrent();
            $table->timestamp('created_at')->useCurrent();
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
