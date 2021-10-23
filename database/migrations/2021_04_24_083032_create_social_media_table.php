<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSocialMediaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('social_media', function (Blueprint $table) {
            $table->id();
            $table->enum('social_media_name',['Facebook','Youtube','Instagram','TikTok','LinkedIn','Twitter','WhatsApp','Zoom','Skype','Telegram','Viber','Messenger','SnapChat','Hangouts','Google Allo','Pinterest']);
            $table->text('url_event');
            $table->string('logo')->nullable();
            $table->string('background_color')->nullable();
            $table->boolean('state')->default(true);
            $table->boolean('credentials')->default(false);
            $table->string('username')->nullable();
            $table->string('user_password')->nullable();
            $table->string('access_token')->nullable();
            $table->string('access_key_id')->nullable();
            $table->string('access_secret_key_id')->nullable();
            $table->string('access_port')->nullable();
            $table->string('access_host')->nullable();
            $table->string('access_api')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('social_media');
    }
}
