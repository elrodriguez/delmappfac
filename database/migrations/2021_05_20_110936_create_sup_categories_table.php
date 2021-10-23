<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSupCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sup_categories', function (Blueprint $table) {
            $table->id();
            $table->string('short_description');
            $table->string('detailed_description')->nullable();
            $table->boolean('state')->default(true);
            $table->unsignedBigInteger('sup_category_id')->nullable();
            $table->timestamps();
            $table->foreign('sup_category_id')->references('id')->on('sup_categories');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sup_categories');
    }
}
