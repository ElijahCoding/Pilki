<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('services', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('legal_entity_id')->unsigned();
            $table->integer('service_category_id')->unsigned();
            $table->json('title');
            $table->json('title_online');
            $table->json('title_cashier');
            $table->string('article');
            $table->string('barcode');
            $table->integer('duration');
            $table->timestamps();

            $table->index(['service_category_id']);
            $table->index(['legal_entity_id']);

            $table->foreign('legal_entity_id')->on('legal_entities')->references('id')->onDelete('cascade');
            $table->foreign('service_category_id')->on('service_categories')->references('id')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('services');
    }
}
