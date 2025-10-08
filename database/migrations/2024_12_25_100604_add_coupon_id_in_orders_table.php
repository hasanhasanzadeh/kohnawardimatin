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
        Schema::table('orders', function (Blueprint $table) {
            $table->string('post_price')->default('0');
            $table->unsignedBigInteger('coupon_id')->nullable()->after('status');
            $table->foreign('coupon_id','orders_coupon_id_fk')->references('id')->on('coupons')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropForeign('orders_coupon_id_fk');
            $table->dropColumn('coupon_id');
            $table->dropColumn('post_price');
        });
    }
};
