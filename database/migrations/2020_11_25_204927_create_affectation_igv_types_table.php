<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateAffectationIgvTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('affectation_igv_types', function (Blueprint $table) {
            $table->string('id')->index();
            $table->boolean('active');
            $table->boolean('exportation')->nullable();
            $table->boolean('free')->nullable();
            $table->string('description');
            $table->timestamps();
        });

        DB::table('affectation_igv_types')->insert([
            ['id' => '10', 'active' => true,  'exportation' => false, 'free' => false, 'description' => 'Gravado - Operación Onerosa'],
            ['id' => '11', 'active' => true,  'exportation' => false, 'free' => true,  'description' => 'Gravado – Retiro por premio'],
            ['id' => '12', 'active' => true,  'exportation' => false, 'free' => true,  'description' => 'Gravado – Retiro por donación'],
            ['id' => '13', 'active' => true,  'exportation' => false, 'free' => true,  'description' => 'Gravado – Retiro'],
            ['id' => '14', 'active' => true,  'exportation' => false, 'free' => true,  'description' => 'Gravado – Retiro por publicidad'],
            ['id' => '15', 'active' => true,  'exportation' => false, 'free' => true,  'description' => 'Gravado – Bonificaciones'],
            ['id' => '16', 'active' => true,  'exportation' => false, 'free' => true,  'description' => 'Gravado – Retiro por entrega a trabajadores'],
            ['id' => '17', 'active' => false, 'exportation' => false, 'free' => true,  'description' => 'Gravado – IVAP'],
            ['id' => '20', 'active' => true,  'exportation' => false, 'free' => false, 'description' => 'Exonerado - Operación Onerosa'],
            ['id' => '21', 'active' => true,  'exportation' => false, 'free' => true,  'description' => 'Exonerado – Transferencia Gratuita'],
            ['id' => '30', 'active' => true,  'exportation' => false, 'free' => false, 'description' => 'Inafecto - Operación Onerosa'],
            ['id' => '31', 'active' => true,  'exportation' => false, 'free' => true,  'description' => 'Inafecto – Retiro por Bonificación'],
            ['id' => '32', 'active' => true,  'exportation' => false, 'free' => true,  'description' => 'Inafecto – Retiro'],
            ['id' => '33', 'active' => true,  'exportation' => false, 'free' => true,  'description' => 'Inafecto – Retiro por Muestras Médicas'],
            ['id' => '34', 'active' => true,  'exportation' => false, 'free' => true,  'description' => 'Inafecto - Retiro por Convenio Colectivo'],
            ['id' => '35', 'active' => true,  'exportation' => false, 'free' => true,  'description' => 'Inafecto – Retiro por premio'],
            ['id' => '36', 'active' => true,  'exportation' => false, 'free' => true,  'description' => 'Inafecto - Retiro por publicidad'],
            ['id' => '37', 'active' => true,  'exportation' => false, 'free' => true,  'description' => 'Inafecto - Transferencia gratuita'],
            ['id' => '40', 'active' => true,  'exportation' => true,  'free' => false, 'description' => 'Exportación de bienes o servicios'],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('affectation_igv_types');
    }
}
