<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateEmployerSchedulesTable.
 */
class CreateEmployerSchedulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employer_schedules', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('unit_id')->unsigned()->nullable();
            $table->integer('employer_id')->unsigned();
            $table->integer('equipment_id')->unsigned();
            $table->timestamp('begin_at')->nullable();
            $table->timestamp('end_at')->nullable();
            $table->tinyInteger('status');
            $table->timestamps();

            $table->index(['unit_id']);
            $table->index(['employer_id']);
            $table->index(['equipment_id']);

            $table->foreign('unit_id')->on('units')->references('id')->onDelete('cascade');
            $table->foreign('employer_id')->on('employers')->references('id')->onDelete('cascade');
            $table->foreign('equipment_id')->on('equipment')->references('id')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('employer_schedules');
    }
}
