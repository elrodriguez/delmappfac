<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBoardsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('boards', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_establishment');
            $table->string('name',20);
            $table->string('level',5);
            $table->boolean('state')->default(true);
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('id_establishment','boards_id_establishment_foreign')->references('id')->on('establishments')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('boards');
    }
}
