<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateIdentityDocumentTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('identity_document_types', function (Blueprint $table) {
            $table->string('id')->index();
            $table->boolean('active');
            $table->string('description');
            $table->timestamps();
        });
        DB::table('identity_document_types')->insert([
            ['id' => '0', 'active' => true,  'description' => 'Doc.trib.no.dom.sin.ruc'],
            ['id' => '1', 'active' => true,  'description' => 'DNI'],
            ['id' => '4', 'active' => true,  'description' => 'CE'],
            ['id' => '6', 'active' => true,  'description' => 'RUC'],
            ['id' => '7', 'active' => true,  'description' => 'Pasaporte'],
            ['id' => 'A', 'active' => false, 'description' => 'Ced. Diplomática de identidad'],
            ['id' => 'B', 'active' => false, 'description' => 'Documento identidad país residencia-no.d'],
            ['id' => 'C', 'active' => false, 'description' => 'Tax Identification Number - TIN – Doc Trib PP.NN'],
            ['id' => 'D', 'active' => false, 'description' => 'Identification Number - IN – Doc Trib PP. JJ'],
            ['id' => 'E', 'active' => false, 'description' => 'TAM- Tarjeta Andina de Migración'],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('identity_document_types');
    }
}
