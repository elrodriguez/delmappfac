<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateStateTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('state_types', function (Blueprint $table) {
            $table->char('id', 2)->index();
            $table->string('description');
            $table->timestamps();
        });
        DB::table('state_types')->insert([
            ['id' => '01', 'description' => 'Registrado'],
            ['id' => '03', 'description' => 'Enviado'],
            ['id' => '05', 'description' => 'Aceptado'],
            ['id' => '07', 'description' => 'Observado'],
            ['id' => '09', 'description' => 'Rechazado'],
            ['id' => '11', 'description' => 'Anulado'],
            ['id' => '13', 'description' => 'Porsi anular'],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('state_types');
    }
}
