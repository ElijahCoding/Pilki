<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEquipmentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('equipment', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('unit_id')->unsigned();
            $table->integer('legal_entity_id')->unsigned();
            $table->string('title');
            $table->string('comment')->nullable();
            $table->integer('status');
            $table->timestamps();

            $table->index(['unit_id']);
            $table->index(['legal_entity_id']);

            $table->foreign('unit_id')->on('units')->references('id')->onDelete('cascade');
            $table->foreign('legal_entity_id')->on('legal_entities')->references('id')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('equipment');
    }
}
