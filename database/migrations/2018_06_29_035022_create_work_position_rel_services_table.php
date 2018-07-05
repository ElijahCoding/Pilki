<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWorkPositionRelServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('work_position_rel_services', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('work_position_id')->unsigned();

            $table->string('service_type');
            $table->integer('service_id')->unsigned();

            $table->timestamps();

            $table->index(['service_type', 'service_id'], 'wp2s_service_index');
            $table->unique(['work_position_id', 'service_type', 'service_id'], 'wp2s_unique');

            $table->foreign('work_position_id')->on('work_positions')->references('id')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
         Schema::dropIfExists('work_position_rel_services');
    }
}
