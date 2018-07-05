<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBookingRelServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('booking_rel_services', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('booking_id')->unsigned();
            $table->integer('service_id')->unsigned();
            $table->timestamps();

            $table->index(['booking_id']);
            $table->index(['service_id']);

            $table->foreign('booking_id')->on('bookings')->references('id')->onDelete('cascade');
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
        Schema::dropIfExists('booking_rel_services');
    }
}
