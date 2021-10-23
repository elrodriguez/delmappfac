<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateManagementTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('management_types', function (Blueprint $table) {
            $table->string('id')->index();
            $table->string('description');
            $table->timestamps();
        });
        DB::table('management_types')->insert([
            ['id'=>'PRI','description'=>'PRIVADA'],
            ['id'=>'PUB','description'=>'PUBLICA']
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('management_types');
    }
}
