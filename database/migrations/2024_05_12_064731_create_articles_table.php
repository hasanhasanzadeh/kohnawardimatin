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
        Schema::create('articles', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('description');
            $table->longText('body');
            $table->boolean('status')->default(0);
            $table->integer('view_count')->default(0);
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id','users_article_user_id_fk')->references('id')->on('users')->cascadeOnDelete()->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('articles', function (Blueprint $table) {
            $table->dropForeign('users_article_user_id_fk');
            $table->dropIfExists();
        });
    }
};
