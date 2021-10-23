<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColomnProyectState extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->enum('state',['pendiente','en desarrollo','detenido','cancelado','terminado'])->default('pendiente');
            $table->string('observation')->nullable();
            $table->unsignedBigInteger('establishment_id')->nullable();
            $table->foreign('establishment_id','projects_establishment_id_fk')->references('id')->on('establishments')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->dropForeign('projects_establishment_id_fk');
            $table->dropColumn('establishment_id');
            $table->dropColumn('observation');
            $table->dropColumn('state');
        });
    }
}
