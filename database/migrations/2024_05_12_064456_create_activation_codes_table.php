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
        Schema::create('activation_codes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id','users_activation_codes_user_id_fk')->references('id')->on('users')->cascadeOnDelete()->cascadeOnUpdate();
            $table->string('code')->nullable();
            $table->tinyInteger('use')->default(0);
            $table->timestamp('expired')->default(\Carbon\Carbon::now());
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('activation_codes', function (Blueprint $table) {
            $table->dropForeign('users_activation_codes_user_id_fk');
            $table->dropIfExists();
        });
    }
};
