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
        Schema::create('carts', function (Blueprint $table) {
            $table->id();
            $table->string('session_id');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id','users_cart_user_id_fk')->references('id')->on('users')->nullOnDelete()->cascadeOnUpdate();
            $table->unsignedBigInteger('post_id')->nullable();
            $table->foreign('post_id','posts_cart_post_id_fk')->references('id')->on('posts')->nullOnDelete()->cascadeOnUpdate();
            $table->integer('quantity');
            $table->string('sum_price');
            $table->string('post_price')->default('0');
            $table->string('total_price');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('carts', function (Blueprint $table) {
            $table->dropForeign('users_cart_user_id_fk');
            $table->dropForeign('posts_cart_post_id_fk');
            $table->dropIfExists();
        });
    }
};
