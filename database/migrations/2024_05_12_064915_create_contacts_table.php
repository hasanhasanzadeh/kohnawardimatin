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
        Schema::create('contacts', function (Blueprint $table) {
            $table->id();
            $table->string('subject')->nullable();
            $table->string('name')->nullable();
            $table->string('email')->nullable();
            $table->string('mobile')->nullable();
            $table->string('ip_address')->nullable();
            $table->longText('message')->nullable();
            $table->boolean('read')->default(0);
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id','users_contact_user_id_fk')->references('id')->on('users')->nullOnDelete()->cascadeOnUpdate();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('contacts', function (Blueprint $table) {
            $table->dropForeign('users_contact_user_id_fk');
            $table->dropIfExists();
        });
    }
};
