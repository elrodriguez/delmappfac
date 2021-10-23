<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClassActivitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('class_activities', function (Blueprint $table) {
            $table->id();
            $table->string('description')->nullable();
            $table->longText('body')->nullable();
            $table->boolean('state')->default(true);
            $table->integer('number')->default(1);
            $table->unsignedBigInteger('academic_type_activitie_id');
            $table->unsignedBigInteger('topic_class_id');
            $table->timestamps();
            $table->foreign('academic_type_activitie_id')->references('id')->on('academic_type_activities')->onDelete('cascade');
            $table->foreign('topic_class_id')->references('id')->on('topic_classes')->onDelete('cascade');
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('class_activities');
    }
}
