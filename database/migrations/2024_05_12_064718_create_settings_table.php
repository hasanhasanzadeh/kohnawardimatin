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
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('url')->nullable();
            $table->string('copy_right')->nullable();
            $table->text('about')->nullable();
            $table->text('address')->nullable();
            $table->string('tel',50)->nullable();
            $table->string('email',150)->nullable();
            $table->text('product_text')->nullable();
            $table->string('free_post')->nullable();
            $table->unsignedBigInteger('favicon_id')->nullable();
            $table->foreign('favicon_id','files_favicon_id_fk')->references('id')->on('files')->nullOnDelete()->cascadeOnUpdate();
            $table->unsignedBigInteger('logo_id')->nullable();
            $table->foreign('logo_id','files_logo_id_fk')->references('id')->on('files')->nullOnDelete()->cascadeOnUpdate();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id','users_setting_user_id_fk')->references('id')->on('users')->cascadeOnDelete()->cascadeOnUpdate();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->dropForeign('files_favicon_id_fk');
            $table->dropForeign('files_logo_id_fk');
            $table->dropForeign('users_setting_user_id_fk');
            $table->dropIfExists();
        });
    }
};
