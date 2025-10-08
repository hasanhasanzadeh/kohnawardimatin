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
        Schema::table('carts', function (Blueprint $table) {
            $table->string('amount')->default('0');
            $table->unsignedBigInteger('coupon_id')->nullable();
            $table->foreign('coupon_id','carts_coupon_id_fk')->references('id')->on('coupons')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('carts', function (Blueprint $table) {
            $table->dropForeign('carts_coupon_id_fk');
            $table->dropColumn('coupon_id');
            $table->dropColumn('amount');
        });
    }
};
