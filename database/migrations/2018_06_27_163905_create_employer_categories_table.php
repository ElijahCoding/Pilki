<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmployerCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employer_categories', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('legal_entity_id')->unsigned();
            $table->string('title');
            $table->json('aliases');
            $table->timestamps();

            $table->index(['legal_entity_id']);

            $table->foreign('legal_entity_id')->on('legal_entities')->references('id')->onDelete('cascade');
        });

        Schema::table('employers', function (Blueprint $table) {
            $table->foreign('employer_category_id')->on('employer_categories')->references('id')->onDelete('set null');
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
            $table->dropForeign('employers_employer_category_id_foreign');
        });

        Schema::dropIfExists('employer_categories');
    }
}
