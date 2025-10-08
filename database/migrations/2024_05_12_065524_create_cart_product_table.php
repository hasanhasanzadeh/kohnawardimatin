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
        Schema::create('cart_product', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('cart_id');
            $table->foreign('cart_id','cart_product_cart_id_fk')->references('id')->on('carts')->cascadeOnDelete()->cascadeOnUpdate();
            $table->unsignedBigInteger('product_id');
            $table->foreign('product_id','cart_product_product_id_fk')->references('id')->on('products')->cascadeOnDelete()->cascadeOnUpdate();
            $table->string('price');
            $table->integer('qty');
            $table->string('sum_price');
            $table->string('option')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cart_product', function (Blueprint $table) {
            $table->dropForeign('cart_product_cart_id_fk');
            $table->dropForeign('cart_product_product_id_fk');
            $table->dropIfExists();
        });
    }
};
