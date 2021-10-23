<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShoConfigurationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sho_configurations', function (Blueprint $table) {
            $table->id();
            $table->string('fixed_phone',20)->nullable();
            $table->string('mobile_phone',20)->nullable();
            $table->string('logo')->nullable();
            $table->string('email')->nullable();
            $table->text('map')->nullable();
            $table->string('address')->nullable();
            $table->boolean('discount')->default(false);
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
        Schema::dropIfExists('sho_configurations');
    }
}
