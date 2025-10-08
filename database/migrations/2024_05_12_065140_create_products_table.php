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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('original_name')->nullable();
            $table->string('sku')->unique();
            $table->string('slug')->unique();
            $table->longText('description')->nullable();
            $table->text('attribute')->nullable();
            $table->string('buy_price')->default('0');
            $table->string('price');
            $table->unsignedInteger('quantity')->default(0);
            $table->enum('status',['active','inactive','soon'])->default('active');
            $table->string('original_price');
            $table->string('discount')->default('0');
            $table->boolean('special')->default(0);
            $table->date('expired_at')->nullable();
            $table->unsignedBigInteger('photo_id')->nullable();
            $table->foreign('photo_id','files_products_photo_id_fk')->references('id')->on('files')->nullOnDelete()->cascadeOnUpdate();
            $table->unsignedBigInteger('brand_id')->nullable();
            $table->foreign('brand_id','brands_brand_id_fk')->references('id')->on('brands')->nullOnDelete()->cascadeOnUpdate();
            $table->unsignedBigInteger('category_id')->nullable();
            $table->foreign('category_id','categories_product_category_id_fk')->references('id')->on('categories')->nullOnDelete()->cascadeOnUpdate();
            $table->unsignedInteger('view_count')->default(0);
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id','users_product_user_id_fk')->references('id')->on('users')->cascadeOnDelete()->cascadeOnUpdate();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropForeign('users_product_user_id_fk');
            $table->dropForeign('categories_product_category_id_fk');
            $table->dropForeign('brands_brand_id_fk');
            $table->dropForeign('files_products_photo_id_fk');
            $table->dropIfExists();
        });
    }
};
