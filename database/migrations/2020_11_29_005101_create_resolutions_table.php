<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateResolutionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('resolutions', function (Blueprint $table) {
            $table->id();
            $table->string('description',500);
            $table->string('number')->nullable();
            $table->string('id_resolution_type')->nullable();
            $table->timestamps();
            $table->foreign('id_resolution_type')->references('id')->on('resolution_types');
        });
        DB::table('resolutions')->insert([
            ['description'=>'RESOLUCION MINISTERIAL N° 138-84-ED','id_resolution_type'=>'RLA'],
            ['description'=>'RESOLUCION DIRECTORAL N° 060-2005-ED','id_resolution_type'=>'RRR']
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('resolutions');
    }
}
