<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnAcademicChargesSeason extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('academic_charges', function (Blueprint $table) {
            $table->string('academic_season_id',4)->nullable();
            $table->foreign('academic_season_id','academic_charges_academic_season_id_fk')->references('id')->on('academic_seasons');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('academic_charges', function (Blueprint $table) {
            $table->dropForeign('academic_charges_academic_season_id_fk');
            $table->dropColumn('academic_season_id');
        });
    }
}
