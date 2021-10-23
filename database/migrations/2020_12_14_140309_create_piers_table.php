<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreatePiersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('piers', function (Blueprint $table) {
            $table->id();
            $table->string('name',300);
            $table->string('address')->nullable();
            $table->char('country_id', 2);
            $table->char('department_id', 2)->nullable();
            $table->char('province_id', 4)->nullable();
            $table->char('district_id', 6)->nullable();
            $table->boolean('state')->default(true);
            $table->timestamps();
            $table->foreign('country_id')->references('id')->on('countries');
            $table->foreign('department_id')->references('id')->on('departments');
            $table->foreign('province_id')->references('id')->on('provinces');
            $table->foreign('district_id')->references('id')->on('districts');
        });
        DB::table('piers')->insert([
            [ 'name' => 'Terminal Portuario General San Martín – Paracas, Pisco.','country_id'=>'PE','department_id'=>'11','province_id'=>'1105','district_id'=>'110501'],
            [ 'name' => 'Terminal Portuario de Yurimaguas – Nueva Reforma.','country_id'=>'PE','department_id'=>'16','province_id'=>'1602','district_id'=>'160201'],
            [ 'name' => 'Terminal Multipropósito Muelle Norte – Callao.','country_id'=>'PE','department_id'=>'07','province_id'=>'0701','district_id'=>'070101'],
            [ 'name' => 'Terminal de Embarque de Concentrados de Minerales – Callao.','country_id'=>'PE','department_id'=>'07','province_id'=>'0701','district_id'=>'070101'],
            [ 'name' => 'Terminal Portuario de Paita.','country_id'=>'PE','department_id'=>'20','province_id'=>'2005','district_id'=>'200501'],
            [ 'name' => 'Terminal de Contenedores Muelle Sur – Callao.','country_id'=>'PE','department_id'=>'07','province_id'=>'0701','district_id'=>'070101'],
            [ 'name' => 'Terminal Portuario de Matarani.','country_id'=>'PE','department_id'=>'04','province_id'=>'0401','district_id'=>'040101'],
            [ 'name' => 'Terminal Portuario Multipropósito de Salaverry.','country_id'=>'PE','department_id'=>'13','province_id'=>'1301','district_id'=>'130101'],
            [ 'name' => 'Empresa Nacional de Puertos S.A. – ENAPU.','country_id'=>'PE','department_id'=>'18','province_id'=>'1803','district_id'=>'180301'],
            [ 'name' => 'Empresa Nacional de Iquitos S.A. – ENAPU','country_id'=>'PE','department_id'=>'16','province_id'=>'1601','district_id'=>'160101'],
            [ 'name' => 'Terminal Portuario de Chimbote','country_id'=>'PE','department_id'=>'02','province_id'=>'0218','district_id'=>'021801']
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('piers');
    }
}
