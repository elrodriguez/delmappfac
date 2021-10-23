<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateNoteDebitTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('note_debit_types', function (Blueprint $table) {
            $table->string('id')->index();
            $table->boolean('active');
            $table->string('description');
            $table->timestamps();
        });

        DB::table('note_debit_types')->insert([
            ['id' => '01', 'active' => true, 'description' => 'Intereses por mora'],
            ['id' => '02', 'active' => true, 'description' => 'Aumento en el valor'],
            ['id' => '03', 'active' => true, 'description' => 'Penalidades/ otros conceptos'],
            ['id' => '10', 'active' => true, 'description' => 'Ajustes de operaciones de exportación'],
            ['id' => '11', 'active' => true, 'description' => 'Ajustes afectos al IVAP'],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('note_debit_types');
    }
}
