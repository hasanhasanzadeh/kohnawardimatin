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
        Schema::create('attributes', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });

        Schema::create('attribute_values', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('attribute_id');
            $table->foreign('attribute_id','attributes_attribute_values_attribute_id_fk')->references('id')->on('attributes')->onDelete('cascade');
            $table->string('value');
            $table->string('price')->default('0');
            $table->timestamps();
        });

        Schema::create('attribute_product', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('attribute_id');
            $table->foreign('attribute_id','attributes_attribute_product_attribute_id_fk')->references('id')->on('attributes')->onDelete('cascade');
            $table->unsignedBigInteger('product_id');
            $table->foreign('product_id','products_attribute_product_product_id_fk')->references('id')->on('products')->onDelete('cascade');

            $table->unsignedBigInteger('value_id');
            $table->foreign('value_id','attribute_values_value_id_fk')->references('id')->on('attribute_values')->onDelete('cascade');
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('attribute_product', function (Blueprint $table) {
            $table->dropForeign('attributes_attribute_product_attribute_id_fk');
            $table->dropForeign('products_attribute_product_product_id_fk');
            $table->dropForeign('attribute_values_value_id_fk');
            $table->dropIfExists();
        });
        Schema::table('attribute_values', function (Blueprint $table) {
            $table->dropForeign('attributes_attribute_values_attribute_id_fk');
            $table->dropIfExists();

        });
        Schema::dropIfExists('attributes');
    }
};
