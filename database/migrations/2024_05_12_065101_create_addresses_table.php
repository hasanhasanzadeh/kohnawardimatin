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
        Schema::create('addresses', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id','users_address_user_id_fk')->references('id')->on('users')->cascadeOnDelete()->cascadeOnUpdate();
            $table->string('post_code')->nullable();
            $table->text('address_text')->nullable();
            $table->string('receptor_name')->nullable();
            $table->string('receptor_mobile')->nullable();
            $table->unsignedBigInteger('city_id');
            $table->foreign('city_id','cities_city_id_fk')->references('id')->on('cities')->cascadeOnDelete()->cascadeOnUpdate();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('addresses', function (Blueprint $table) {
            $table->dropForeign('users_address_user_id_fk');
            $table->dropForeign('cities_city_id_fk');
            $table->dropIfExists();
        });
    }
};
