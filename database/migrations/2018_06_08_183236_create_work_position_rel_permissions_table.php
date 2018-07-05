<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWorkPositionRelPermissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('work_position_rel_permissions', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('work_position_id')->unsigned();

            $table->string('permission_type');
            $table->integer('permission_id')->unsigned();

            $table->timestamps();

            $table->index(['permission_type', 'permission_id'], 'wp2p_permission_index');
            $table->unique(['work_position_id', 'permission_type', 'permission_id'], 'wp2p_unique');

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
        Schema::dropIfExists('work_position_rel_permissions');

    }
}
