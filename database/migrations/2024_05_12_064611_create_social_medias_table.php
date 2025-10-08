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
        Schema::create('social_medias', function (Blueprint $table) {
            $table->id();
            $table->string('telegram',150)->nullable();
            $table->string('instagram',150)->nullable();
            $table->string('whatsapp',150)->nullable();
            $table->string('facebook',150)->nullable();
            $table->string('x_link',150)->nullable();
            $table->string('linkedin',150)->nullable();
            $table->string('youtube',150)->nullable();
            $table->string('map_data',150)->nullable();
            $table->string('google_plus',150)->nullable();
            $table->morphs('socialmediaable');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('social_medias');
    }
};
