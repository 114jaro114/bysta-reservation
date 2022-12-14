<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePricesEachMonthTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('prices_each_month', function (Blueprint $table) {
            $table->id();
            $table->string('month');
            $table->string('price');
            $table->string('type');
            // $table->string('jan');
            // $table->string('feb');
            // $table->string('mar');
            // $table->string('apr');
            // $table->string('may');
            // $table->string('jun');
            // $table->string('jul');
            // $table->string('aug');
            // $table->string('sep');
            // $table->string('oct');
            // $table->string('nov');
            // $table->string('dec');
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
        Schema::dropIfExists('prices_each_month');
    }
}
