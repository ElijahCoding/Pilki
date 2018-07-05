<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWindowsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('windows', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('unit_id')->unsigned();
            $table->integer('employer_id')->unsigned();
            $table->integer('equipment_id')->unsigned();
            $table->integer('booking_id')->unsigned()->nullable();
            $table->timestamp('begin_at')->nullable();
            $table->timestamp('end_at')->nullable();
            $table->integer('duration_original');
            $table->integer('duration');
            $table->timestamps();

            $table->index(['employer_id']);
            $table->index(['equipment_id']);
            $table->index(['unit_id']);

            $table->foreign('unit_id')->on('units')->references('id')->onDelete('cascade');
            $table->foreign('employer_id')->on('employers')->references('id')->onDelete('cascade');
            $table->foreign('equipment_id')->on('equipment')->references('id')->onDelete('cascade');
            $table->foreign('booking_id')->on('bookings')->references('id')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('windows');
    }
}
