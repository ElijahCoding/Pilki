<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmployersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employers', function (Blueprint $table) {
            $table->increments('id');
            $table->string('first_name');
            $table->string('middle_name')->nullable();
            $table->string('last_name');
            $table->integer('unit_id')->unsigned()->nullable();
            $table->integer('metro_id')->unsigned()->nullable();
            $table->integer('legal_entity_id')->unsigned()->nullable();
            $table->integer('work_position_id')->unsigned();
            $table->integer('employer_category_id')->unsigned()->nullable();
            $table->integer('schedule_type');

            $table->string('phone', 15)->unique();
            $table->string('email')->unique();

            $table->integer('region_id')->nullable();
            $table->integer('country_id')->nullable();
            $table->integer('parent_employer_id')->unsigned()->nullable();
            $table->string('school')->nullable();

            $table->string('password');
            $table->string('remember_password')->nullable();
            $table->boolean('is_superuser')->default(false);

            $table->integer('status');
            $table->string('education')->nullable();

            $table->rememberToken();

            $table->timestamp('interview_at')->nullable();
            $table->timestamp('start_work_at')->nullable();
            $table->timestamps();

            $table->index(['unit_id']);
            $table->index(['legal_entity_id']);
            $table->index(['metro_id']);

            $table->foreign('unit_id')->on('units')->references('id')->onDelete('cascade');
            $table->foreign('legal_entity_id')->on('legal_entities')->references('id')->onDelete('cascade');
        });

        Schema::table('employers', function (Blueprint $table) {
            $table->foreign('parent_employer_id')->on('employers')->references('id')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
