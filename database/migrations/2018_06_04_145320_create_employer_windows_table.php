<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmployerWindowsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employer_windows', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('employer_id')->unsigned();
            $table->integer('service_category_id')->unsigned();
            $table->timestamp('begin_at')->nullable();
            $table->timestamp('end_at')->nullable();
            $table->json('schedule');
            $table->timestamps();

            $table->index(['employer_id', 'service_category_id']);

            $table->foreign('employer_id')->on('employers')->references('id')->onDelete('cascade');
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
        Schema::dropIfExists('employer_windows');
    }
}
