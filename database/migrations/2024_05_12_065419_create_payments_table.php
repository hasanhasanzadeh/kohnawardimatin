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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->string("authority");
            $table->string("amount");
            $table->enum('status',['done','pending','undone']);
            $table->string("RefID")->nullable();
            $table->unsignedBigInteger('paymentable_id')->nullable();
            $table->string('paymentable_type')->nullable();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id','users_payment_user_id_fk')->references('id')->on('users')->cascadeOnDelete()->cascadeOnUpdate();
            $table->string('pay_wallet')->default('0');
            $table->string('pay_get_way')->default('0');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->dropForeign('users_payment_user_id_fk');
            $table->dropIfExists();
        });
    }
};
