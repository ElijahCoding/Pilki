<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateWorkPositionsTable.
 */
class CreateWorkPositionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('work_positions', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('legal_entity_id')->unsigned();
            $table->string('title');
            $table->timestamps();

            $table->index(['legal_entity_id']);
            $table->foreign('legal_entity_id')->on('legal_entities')->references('id')->onDelete('cascade');
        });


        Schema::table('employers', function (Blueprint $table) {
            $table->foreign('work_position_id')->on('work_positions')->references('id')->onDelete('cascade');
            $table->index(['work_position_id']);
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('employers', function (Blueprint $table) {
            $table->dropForeign('employers_work_position_id_foreign');
        });

        Schema::drop('work_positions');
    }
}
