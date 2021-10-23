<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateNoteCreditTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('note_credit_types', function (Blueprint $table) {
            $table->string('id')->index();
            $table->boolean('active');
            $table->string('description');
            $table->timestamps();
        });

        DB::table('note_credit_types')->insert([
            ['id' => '01', 'active' => true, 'description' => 'Anulación de la operación'],
            ['id' => '02', 'active' => true, 'description' => 'Anulación por error en el RUC'],
            ['id' => '03', 'active' => true, 'description' => 'Corrección por error en la descripción'],
            ['id' => '04', 'active' => true, 'description' => 'Descuento global'],
            ['id' => '05', 'active' => true, 'description' => 'Descuento por ítem'],
            ['id' => '06', 'active' => true, 'description' => 'Devolución total'],
            ['id' => '07', 'active' => true, 'description' => 'Devolución por ítem'],
            ['id' => '08', 'active' => true, 'description' => 'Bonificación'],
            ['id' => '09', 'active' => true, 'description' => 'Disminución en el valor'],
            ['id' => '10', 'active' => true, 'description' => 'Otros Conceptos'],
            ['id' => '11', 'active' => true, 'description' => 'Ajustes de operaciones de exportación'],
            ['id' => '12', 'active' => true, 'description' => 'Ajustes afectos al IVAP'],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('note_credit_types');
    }
}
