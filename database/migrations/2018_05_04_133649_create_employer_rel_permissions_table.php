<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmployerRelPermissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employer_rel_permissions', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('employer_id')->unsigned();

            $table->string('permission_type');
            $table->integer('permission_id')->unsigned();

            $table->string('access_type')->nullable();
            $table->unsignedBigInteger('access_id')->nullable();

            $table->timestamp('date_from')->nullable();
            $table->timestamp('date_to')->nullable();
            $table->timestamps();

            $table->index(['permission_type', 'permission_id']);
            $table->index(['access_type', 'access_id']);
            $table->index(['employer_id', 'permission_type', 'permission_id'], 'e2p_permission_index');
            $table->unique(['employer_id', 'permission_type', 'permission_id', 'access_type', 'access_id'],
                'e2p_access_unique');

            $table->foreign('employer_id')->on('employers')->references('id')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('employer_rel_permissions');
    }
}
