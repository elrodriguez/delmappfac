<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSupTicketsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sup_tickets', function (Blueprint $table) {
            $table->id();
            $table->string('internal_id',20);
            $table->unsignedBigInteger('sup_panic_level_id');
            $table->unsignedBigInteger('sup_service_area_id');
            $table->unsignedBigInteger('sup_category_id');
            $table->unsignedBigInteger('sup_reception_mode_id');
            $table->unsignedBigInteger('establishment_id');
            $table->text('description_of_problem')->nullable();
            $table->string('ip_pc')->nullable();
            $table->string('browser');
            $table->text('derivation_return_description')->nullable();
            $table->text('description_completion_rejection')->nullable();
            $table->string('version_sicmact')->nullable();
            $table->enum('state',['sent','derivative','attended','cancel','closed_ok','closed_fail','pause']);
            $table->date('date_application');
            $table->date('date_attended')->nullable();
            $table->date('date_finished')->nullable();
            $table->timestamps();
            $table->foreign('sup_panic_level_id')->references('id')->on('sup_panic_levels');
            $table->foreign('sup_service_area_id')->references('id')->on('sup_service_areas');
            $table->foreign('sup_category_id')->references('id')->on('sup_categories');
            $table->foreign('sup_reception_mode_id')->references('id')->on('sup_reception_modes');
            $table->foreign('establishment_id')->references('id')->on('establishments');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sup_tickets');
    }
}
