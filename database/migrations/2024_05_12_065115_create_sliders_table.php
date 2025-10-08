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
        Schema::create('sliders', function (Blueprint $table) {
            $table->id();
            $table->boolean('status')->default(false);
            $table->unsignedBigInteger('category_id');
            $table->foreign('category_id','categories_category_id_fk')->references('id')->on('categories')->cascadeOnDelete()->cascadeOnUpdate();
            $table->enum('rang',['slider','step-3','step-2','step-4','step-1','banner','link'])->default('slider');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sliders', function (Blueprint $table) {
            $table->dropForeign('categories_category_id_fk');
            $table->dropIfExists();
        });
    }
};
