<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AddColumsEstablishment extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('companies', function (Blueprint $table) {
            $table->string('id_management_type')->nullable();
            $table->foreign('id_management_type','companies_idmanagementtype_foreign')->references('id')->on('management_types');
        });
        Schema::table('establishments', function (Blueprint $table) {
            $table->unsignedBigInteger('id_company')->nullable();
            $table->char('country_id', 2)->nullable();
            $table->char('department_id', 2)->nullable();
            $table->char('province_id', 4)->nullable();
            $table->char('district_id', 6)->nullable();
            $table->string('web_page')->nullable();
            $table->string('email')->nullable();
            $table->foreign('id_company','establishments_id_company_foreign')->references('id')->on('companies');
            $table->foreign('country_id','establishments_country_id_foreign')->references('id')->on('countries');
            $table->foreign('department_id','establishments_department_id_foreign')->references('id')->on('departments');
            $table->foreign('province_id','establishments_province_id_foreign')->references('id')->on('provinces');
            $table->foreign('district_id','establishments_district_id_foreign')->references('id')->on('districts');
        });
        DB::table('establishments')->insert([
            'name' => 'Oficina Principal',
            'country_id'=>'PE',
            'department_id'=>'02',
            'province_id'=>'0218',
            'district_id'=>'021801'
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('establishments', function (Blueprint $table) {
            $table->dropForeign('establishments_id_company_foreign');
            $table->dropForeign('establishments_country_id_foreign');
            $table->dropForeign('establishments_department_id_foreign');
            $table->dropForeign('establishments_province_id_foreign');
            $table->dropForeign('establishments_district_id_foreign');
            $table->dropColumn('id_company');
            $table->dropColumn('country_id');
            $table->dropColumn('department_id');
            $table->dropColumn('province_id');
            $table->dropColumn('district_id');
            $table->dropColumn('web_page');
            $table->dropColumn('email');
        });
        Schema::table('companies', function (Blueprint $table) {
            $table->dropForeign('companies_idmanagementtype_foreign');
            $table->dropColumn('id_management_type');
        });
    }
}
