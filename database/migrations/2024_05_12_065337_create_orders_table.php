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
            $table->string('amount');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id','users_order_user_id_fk')->references('id')->on('users')->cascadeOnDelete()->cascadeOnUpdate();
            $table->unsignedBigInteger('address_id')->nullable();
            $table->foreign('address_id','addresses_address_id_fk')->references('id')->on('addresses')->nullOnDelete()->cascadeOnUpdate();
            $table->boolean('status')->default(0);
            $table->enum('status_send',['sending','send','process'])->default('process');
            $table->unsignedBigInteger('post_id')->nullable();
            $table->foreign('post_id','posts_post_id_fk')->references('id')->on('posts')->nullOnDelete()->cascadeOnUpdate();
            $table->string('serial',50)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropForeign('users_order_user_id_fk');
            $table->dropForeign('posts_post_id_fk');
            $table->dropForeign('addresses_address_id_fk');
            $table->dropIfExists();
        });
    }
};
