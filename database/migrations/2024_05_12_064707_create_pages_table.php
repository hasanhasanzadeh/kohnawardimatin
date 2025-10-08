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
        Schema::create('pages', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->boolean('status')->default('0');
            $table->unsignedBigInteger('page_cat_id')->nullable();
            $table->foreign('page_cat_id','page_cats_page_cat_id_fk')->references('id')->on('page_cats')->cascadeOnDelete()->cascadeOnUpdate();
            $table->longText('description')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pages', function (Blueprint $table) {
            $table->dropForeign('page_cats_page_cat_id_fk');
            $table->dropIfExists();
        });
    }
};
