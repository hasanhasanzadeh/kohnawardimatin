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
        Schema::create('order_product', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('order_id');
            $table->foreign('order_id','orders_order_id_fk')->references('id')->on('orders')->cascadeOnDelete()->cascadeOnUpdate();
            $table->unsignedBigInteger('product_id');
            $table->foreign('product_id','products_product_id_fk')->references('id')->on('products')->cascadeOnDelete()->cascadeOnUpdate();
            $table->string('original_price')->default('0');
            $table->string('price');
            $table->string('discount')->default('0');
            $table->integer('qty')->default('0');
            $table->string('option')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('order_product', function (Blueprint $table) {
            $table->dropForeign('orders_order_id_fk');
            $table->dropForeign('products_product_id_fk');
            $table->dropIfExists();
        });
    }
};
