<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReservationsUserContactInfoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reservations_user_contact_info', function (Blueprint $table) {
          $table->increments('id');
          $table->string('reservation_id');
          $table->string('user_id');
          $table->string('surname')->nullable();
          $table->string('lastname')->nullable();
          $table->string('address')->nullable();
          $table->string('city')->nullable();
          $table->string('postcode')->nullable();
          $table->string('country')->nullable();
          $table->string('phone')->nullable();
          $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reservations_user_contact_info');
    }
}
