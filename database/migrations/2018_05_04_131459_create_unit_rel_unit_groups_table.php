<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUnitRelUnitGroupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('unit_rel_unit_groups', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('unit_group_id')->unsigned();
            $table->integer('unit_id')->unsigned();
            $table->timestamps();

            $table->unique(['unit_group_id', 'unit_id']);

            $table->foreign('unit_group_id')->on('unit_groups')->references('id')->onDelete('cascade');
            $table->foreign('unit_id')->on('units')->references('id')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('unit_rel_unit_groups');
    }
}
