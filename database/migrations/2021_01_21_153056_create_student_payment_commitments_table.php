<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentPaymentCommitmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('student_payment_commitments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('cadastre_id');
            $table->unsignedBigInteger('package_id');
            $table->unsignedBigInteger('package_item_detail_id');
            $table->unsignedBigInteger('student_id');
            $table->unsignedBigInteger('person_id');
            $table->json('package_item_detail');
            $table->boolean('state')->default(false);
            $table->date('payment_date')->nullable();
            $table->timestamps();
            $table->foreign('cadastre_id')->references('id')->on('cadastres')->onDelete('cascade');
            $table->foreign('package_id')->references('id')->on('packages')->onDelete('cascade');
            $table->foreign('package_item_detail_id')->references('id')->on('package_item_details')->onDelete('cascade');
            $table->foreign('student_id')->references('id')->on('students')->onDelete('cascade');
            $table->foreign('person_id')->references('id')->on('people')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('student_payment_commitments');
    }
}
