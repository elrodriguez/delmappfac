<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateSeriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('series', function (Blueprint $table) {
            $table->string('id',4)->index();
            $table->integer('correlative');
            $table->unsignedBigInteger('establishment_id')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('document_type_id')->nullable();
            $table->boolean('state')->default(true);
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('establishment_id','series_establishment_id_foreign')->references('id')->on('establishments')->onDelete('cascade');
            $table->foreign('user_id','series_user_id_foreign')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('document_type_id','series_document_type_id_foreign')->references('id')->on('document_types')->onDelete('cascade');
        });
        DB::table('series')->insert([
            [
                'id' => 'B001',
                'correlative'=>1,
                'establishment_id'=>'1',
                'document_type_id' => '03',
                'state' => true,
                'created_at' => date('Y-m-d')
            ],
            [
                'id' => 'F001',
                'correlative'=>1,
                'establishment_id'=>'1',
                'document_type_id' => '01',
                'state' => true,
                'created_at' => date('Y-m-d')
            ]
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('series');
    }
}
