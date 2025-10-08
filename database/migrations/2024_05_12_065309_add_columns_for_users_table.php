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
        Schema::table('users', function (Blueprint $table) {
            $table->string('card_number',24)->nullable()->after('password');
            $table->string('wallet',20)->default('0');
            $table->unsignedBigInteger('city_id')->nullable()->after('wallet');
            $table->foreign('city_id','cities_users_city_id_fk')->references('id')->on('cities')->nullOnDelete()->cascadeOnUpdate();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign('cities_users_city_id_fk');
            $table->dropColumn('city_id');
            $table->dropColumn('card_number');
            $table->dropColumn('wallet');
        });
    }
};
