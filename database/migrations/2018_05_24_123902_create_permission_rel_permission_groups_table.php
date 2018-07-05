<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePermissionRelPermissionGroupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('permission_rel_permission_groups', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('permission_group_id')->unsigned();
            $table->integer('permission_id')->unsigned();
            $table->timestamps();

            $table->unique(['permission_group_id', 'permission_id'], 'p2pg_permission_unique');

            $table->foreign('permission_group_id')->on('permission_groups')->references('id')->onDelete('cascade');
            $table->foreign('permission_id')->on('permissions')->references('id')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('permission_rel_permission_groups');
    }
}
