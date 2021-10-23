<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateFreezersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('freezers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->boolean('state')->default(true);
            $table->timestamps();
        });
        DB::table('freezers')->insert([
            ['name'=>'congelador 1'],
            ['name'=>'congelador 2'],
            ['name'=>'congelador 3'],
            ['name'=>'congelador 4']
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('freezers');
    }
}
