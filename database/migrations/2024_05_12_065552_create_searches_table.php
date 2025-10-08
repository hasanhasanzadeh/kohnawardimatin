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
        Schema::create('searches', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id','users_search_user_id_fk')->references('id')->on('users')->nullOnDelete()->cascadeOnUpdate();
            $table->string('search_text')->nullable();
            $table->string('ip_address')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('searches', function (Blueprint $table) {
            $table->dropForeign('users_search_user_id_fk');
            $table->dropIfExists();
        });
    }
};
