<?php

use App\Models\Academic\Administration\AcademicLevel;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AddColumnLevelYear extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('academic_years', function (Blueprint $table) {
            $table->unsignedBigInteger('academic_level_id')->nullable();
            $table->foreign('academic_level_id','academic_years_level_id_fk')->references('id')->on('academic_levels')->onDelete('cascade');
        });

        DB::table('academic_levels')->insert([
            'description' => 'Capacitaciones'
        ]);
        $level = AcademicLevel::max('id');
        DB::table('academic_years')->insert([
            ['description' => 'Sector Publico','academic_level_id' => $level],
            ['description' => 'Derecho','academic_level_id' => $level],
            ['description' => 'Especializados','academic_level_id' => $level]
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('academic_years', function (Blueprint $table) {
            $table->dropForeign('academic_years_level_id_fk');
            $table->dropColumn('academic_level_id');
        });
    }
}
