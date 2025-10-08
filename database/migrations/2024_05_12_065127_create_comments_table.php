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
        Schema::create('comments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('parent_id')->default(0);
            $table->text('title')->nullable();
            $table->text('message');
            $table->boolean('status')->default(0);
            $table->unsignedBigInteger('commentable_id')->default(0);
            $table->string('commentable_type');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id','users_comment_user_id_fk')->references('id')->on('users')->cascadeOnDelete()->cascadeOnUpdate();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('comments', function (Blueprint $table) {
            $table->dropForeign('users_comment_user_id_fk');
            $table->dropIfExists();
        });
    }
};
