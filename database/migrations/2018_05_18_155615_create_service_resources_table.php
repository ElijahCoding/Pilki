<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateServiceResourcesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('service_resources', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('legal_entity_id')->unsigned();
            $table->integer('service_id')->unsigned();
            $table->string('type');
            $table->integer('count')->unsigned();
            $table->timestamps();

            $table->unique(['service_id', 'type']);
            $table->index(['legal_entity_id']);

            $table->foreign('legal_entity_id')->on('legal_entities')->references('id')->onDelete('cascade');
            $table->foreign('service_id')->on('services')->references('id')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('service_resources');
    }
}
