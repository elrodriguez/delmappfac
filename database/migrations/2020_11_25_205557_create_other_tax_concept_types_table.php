<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateOtherTaxConceptTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('other_tax_concept_types', function (Blueprint $table) {
            $table->string('id')->index();
            $table->boolean('active');
            $table->string('description');
            $table->timestamps();
        });

        DB::table('other_tax_concept_types')->insert([
            ['id' => '1000', 'active' => true, 'description' => 'Total valor de venta - operaciones exportadas'],
            ['id' => '1001', 'active' => true, 'description' => 'Total valor de venta - operaciones gravadas'],
            ['id' => '1002', 'active' => true, 'description' => 'Total valor de venta - operaciones inafectas'],
            ['id' => '1003', 'active' => true, 'description' => 'Total valor de venta - operaciones exoneradas'],
            ['id' => '1004', 'active' => true, 'description' => 'Total valor de venta – Operaciones gratuitas'],
            ['id' => '1005', 'active' => true, 'description' => 'Sub total de venta'],
            ['id' => '2001', 'active' => true, 'description' => 'Percepciones'],
            ['id' => '2002', 'active' => true, 'description' => 'Retenciones'],
            ['id' => '2003', 'active' => true, 'description' => 'Detracciones'],
            ['id' => '2004', 'active' => true, 'description' => 'Bonificaciones'],
            ['id' => '2005', 'active' => true, 'description' => 'Total descuentos'],
            ['id' => '3001', 'active' => true, 'description' => 'FISE (Ley 29852) Fondo Inclusión Social Energético'],
        ]);

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('other_tax_concept_types');
    }
}
