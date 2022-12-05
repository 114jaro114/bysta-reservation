<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReservationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reservations', function (Blueprint $table) {
            $table->increments('id');
            $table->string('event_name');
            $table->string('user_id');
            $table->string('username');
            $table->string('start_date');
            $table->string('end_date');
            $table->string('start_time');
            $table->string('end_time');
            $table->string('nights');
            $table->string('adults');
            $table->string('childs_2_to_12');
            $table->string('childs_to_2');
            $table->string('cleaning_fee');
            $table->string('price_for_night');
            $table->string('total_persons');
            $table->string('overall_price');
            $table->string('seen_changes_admin')->default(false);
            $table->string('seen_changes_user')->default(false);
            $table->string('note')->nullable();
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
        Schema::dropIfExists('reservations');
    }
}
