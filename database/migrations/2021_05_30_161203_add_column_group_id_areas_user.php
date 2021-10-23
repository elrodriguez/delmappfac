<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnGroupIdAreasUser extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sup_service_area_users', function (Blueprint $table) {
            $table->unsignedBigInteger('sup_service_area_group_id')->nullable();
            $table->foreign('sup_service_area_group_id','sup_service_area_users_sup_service_area_group_id_fk')->references('id')->on('sup_service_area_groups');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sup_service_area_users', function (Blueprint $table) {
            $table->dropForeign('sup_service_area_users_sup_service_area_group_id_fk');
            $table->dropColumn('sup_service_area_group_id');
        });
    }
}
