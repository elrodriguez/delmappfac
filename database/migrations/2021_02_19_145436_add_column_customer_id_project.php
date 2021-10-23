<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnCustomerIdProject extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('person_id')->nullable();
            $table->foreign('person_id','customers_person_id_fk')->references('id')->on('people');
        });
        Schema::table('projects', function (Blueprint $table) {
            $table->unsignedBigInteger('customer_id')->nullable();
            $table->unsignedBigInteger('person_customer_id')->nullable();
            $table->foreign('customer_id','projects_customer_id_fk')->references('id')->on('customers');
            $table->foreign('person_customer_id','projects_person_customer_id_fk')->references('id')->on('people');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->dropForeign('projects_customer_id_fk');
            $table->dropForeign('projects_person_customer_id_fk');
            $table->dropColumn('person_customer_id');
            $table->dropColumn('customer_id');
        });
        Schema::dropIfExists('customers');
    }
}
