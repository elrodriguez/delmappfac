<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumsPeoplePlaceOfBirth extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('people', function (Blueprint $table) {
            $table->string('last_paternal');
            $table->string('last_maternal');
            $table->string('sex',1)->default(1);
            $table->string('marital_state')->nullable();
            $table->date('birth_date')->nullable();
            $table->string('place_birth')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('people', function (Blueprint $table) {
            $table->dropColumn('last_paternal');
            $table->dropColumn('last_maternal');
            $table->dropColumn('sex');
            $table->dropColumn('marital_state');
            $table->dropColumn('birth_date');
            $table->dropColumn('place_birth');
        });
    }
}
