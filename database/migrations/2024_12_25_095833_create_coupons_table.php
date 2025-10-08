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
        Schema::create('coupons', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('code');
            $table->longText('description')->nullable();
            $table->integer('discount')->default(0);
            $table->boolean('status')->default(false);
            $table->date('expired_at')->default(\Carbon\Carbon::now()->format('Y-m-d'));
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id','users_coupons_user_id_fk')->references('id')->on('users')->cascadeOnDelete()->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('coupons', function (Blueprint $table) {
            $table->dropForeign('users_coupons_user_id_fk');
            $table->dropIfExists();
        });
    }
};
