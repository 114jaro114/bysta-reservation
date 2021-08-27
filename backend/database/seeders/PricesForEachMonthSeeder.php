<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PricesForEachMonthSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      $data = [
        ['month' => 'jan', 'price' => '0', 'type' => 'adults', 'created_at' => Carbon::now()->toDateTimeString(), 'updated_at' => Carbon::now()->toDateTimeString()],
        ['month' => 'feb', 'price' => '0', 'type' => 'adults', 'created_at' => Carbon::now()->toDateTimeString(), 'updated_at' => Carbon::now()->toDateTimeString()],
        ['month' => 'mar', 'price' => '0', 'type' => 'adults', 'created_at' => Carbon::now()->toDateTimeString(), 'updated_at' => Carbon::now()->toDateTimeString()],
        ['month' => 'apr', 'price' => '0', 'type' => 'adults', 'created_at' => Carbon::now()->toDateTimeString(), 'updated_at' => Carbon::now()->toDateTimeString()],
        ['month' => 'may', 'price' => '0', 'type' => 'adults', 'created_at' => Carbon::now()->toDateTimeString(), 'updated_at' => Carbon::now()->toDateTimeString()],
        ['month' => 'jun', 'price' => '0', 'type' => 'adults', 'created_at' => Carbon::now()->toDateTimeString(), 'updated_at' => Carbon::now()->toDateTimeString()],
        ['month' => 'jul', 'price' => '0', 'type' => 'adults', 'created_at' => Carbon::now()->toDateTimeString(), 'updated_at' => Carbon::now()->toDateTimeString()],
        ['month' => 'aug', 'price' => '0', 'type' => 'adults', 'created_at' => Carbon::now()->toDateTimeString(), 'updated_at' => Carbon::now()->toDateTimeString()],
        ['month' => 'sep', 'price' => '0', 'type' => 'adults', 'created_at' => Carbon::now()->toDateTimeString(), 'updated_at' => Carbon::now()->toDateTimeString()],
        ['month' => 'oct', 'price' => '0', 'type' => 'adults', 'created_at' => Carbon::now()->toDateTimeString(), 'updated_at' => Carbon::now()->toDateTimeString()],
        ['month' => 'nov', 'price' => '0', 'type' => 'adults', 'created_at' => Carbon::now()->toDateTimeString(), 'updated_at' => Carbon::now()->toDateTimeString()],
        ['month' => 'dec', 'price' => '0', 'type' => 'adults', 'created_at' => Carbon::now()->toDateTimeString(), 'updated_at' => Carbon::now()->toDateTimeString()],

        ['month' => 'jan', 'price' => '0', 'type' => 'child_from_2_to_12', 'created_at' => Carbon::now()->toDateTimeString(), 'updated_at' => Carbon::now()->toDateTimeString()],
        ['month' => 'feb', 'price' => '0', 'type' => 'child_from_2_to_12', 'created_at' => Carbon::now()->toDateTimeString(), 'updated_at' => Carbon::now()->toDateTimeString()],
        ['month' => 'mar', 'price' => '0', 'type' => 'child_from_2_to_12', 'created_at' => Carbon::now()->toDateTimeString(), 'updated_at' => Carbon::now()->toDateTimeString()],
        ['month' => 'apr', 'price' => '0', 'type' => 'child_from_2_to_12', 'created_at' => Carbon::now()->toDateTimeString(), 'updated_at' => Carbon::now()->toDateTimeString()],
        ['month' => 'may', 'price' => '0', 'type' => 'child_from_2_to_12', 'created_at' => Carbon::now()->toDateTimeString(), 'updated_at' => Carbon::now()->toDateTimeString()],
        ['month' => 'jun', 'price' => '0', 'type' => 'child_from_2_to_12', 'created_at' => Carbon::now()->toDateTimeString(), 'updated_at' => Carbon::now()->toDateTimeString()],
        ['month' => 'jul', 'price' => '0', 'type' => 'child_from_2_to_12', 'created_at' => Carbon::now()->toDateTimeString(), 'updated_at' => Carbon::now()->toDateTimeString()],
        ['month' => 'aug', 'price' => '0', 'type' => 'child_from_2_to_12', 'created_at' => Carbon::now()->toDateTimeString(), 'updated_at' => Carbon::now()->toDateTimeString()],
        ['month' => 'sep', 'price' => '0', 'type' => 'child_from_2_to_12', 'created_at' => Carbon::now()->toDateTimeString(), 'updated_at' => Carbon::now()->toDateTimeString()],
        ['month' => 'oct', 'price' => '0', 'type' => 'child_from_2_to_12', 'created_at' => Carbon::now()->toDateTimeString(), 'updated_at' => Carbon::now()->toDateTimeString()],
        ['month' => 'nov', 'price' => '0', 'type' => 'child_from_2_to_12', 'created_at' => Carbon::now()->toDateTimeString(), 'updated_at' => Carbon::now()->toDateTimeString()],
        ['month' => 'dec', 'price' => '0', 'type' => 'child_from_2_to_12', 'created_at' => Carbon::now()->toDateTimeString(), 'updated_at' => Carbon::now()->toDateTimeString()],

        ['month' => 'jan', 'price' => '0', 'type' => 'child_to_2', 'created_at' => Carbon::now()->toDateTimeString(), 'updated_at' => Carbon::now()->toDateTimeString()],
        ['month' => 'feb', 'price' => '0', 'type' => 'child_to_2', 'created_at' => Carbon::now()->toDateTimeString(), 'updated_at' => Carbon::now()->toDateTimeString()],
        ['month' => 'mar', 'price' => '0', 'type' => 'child_to_2', 'created_at' => Carbon::now()->toDateTimeString(), 'updated_at' => Carbon::now()->toDateTimeString()],
        ['month' => 'apr', 'price' => '0', 'type' => 'child_to_2', 'created_at' => Carbon::now()->toDateTimeString(), 'updated_at' => Carbon::now()->toDateTimeString()],
        ['month' => 'may', 'price' => '0', 'type' => 'child_to_2', 'created_at' => Carbon::now()->toDateTimeString(), 'updated_at' => Carbon::now()->toDateTimeString()],
        ['month' => 'jun', 'price' => '0', 'type' => 'child_to_2', 'created_at' => Carbon::now()->toDateTimeString(), 'updated_at' => Carbon::now()->toDateTimeString()],
        ['month' => 'jul', 'price' => '0', 'type' => 'child_to_2', 'created_at' => Carbon::now()->toDateTimeString(), 'updated_at' => Carbon::now()->toDateTimeString()],
        ['month' => 'aug', 'price' => '0', 'type' => 'child_to_2', 'created_at' => Carbon::now()->toDateTimeString(), 'updated_at' => Carbon::now()->toDateTimeString()],
        ['month' => 'sep', 'price' => '0', 'type' => 'child_to_2', 'created_at' => Carbon::now()->toDateTimeString(), 'updated_at' => Carbon::now()->toDateTimeString()],
        ['month' => 'oct', 'price' => '0', 'type' => 'child_to_2', 'created_at' => Carbon::now()->toDateTimeString(), 'updated_at' => Carbon::now()->toDateTimeString()],
        ['month' => 'nov', 'price' => '0', 'type' => 'child_to_2', 'created_at' => Carbon::now()->toDateTimeString(), 'updated_at' => Carbon::now()->toDateTimeString()],
        ['month' => 'dec', 'price' => '0', 'type' => 'child_to_2', 'created_at' => Carbon::now()->toDateTimeString(), 'updated_at' => Carbon::now()->toDateTimeString()],

        ['month' => 'jan', 'price' => '0', 'type' => 'cleaningFee', 'created_at' => Carbon::now()->toDateTimeString(), 'updated_at' => Carbon::now()->toDateTimeString()],
        ['month' => 'feb', 'price' => '0', 'type' => 'cleaningFee', 'created_at' => Carbon::now()->toDateTimeString(), 'updated_at' => Carbon::now()->toDateTimeString()],
        ['month' => 'mar', 'price' => '0', 'type' => 'cleaningFee', 'created_at' => Carbon::now()->toDateTimeString(), 'updated_at' => Carbon::now()->toDateTimeString()],
        ['month' => 'apr', 'price' => '0', 'type' => 'cleaningFee', 'created_at' => Carbon::now()->toDateTimeString(), 'updated_at' => Carbon::now()->toDateTimeString()],
        ['month' => 'may', 'price' => '0', 'type' => 'cleaningFee', 'created_at' => Carbon::now()->toDateTimeString(), 'updated_at' => Carbon::now()->toDateTimeString()],
        ['month' => 'jun', 'price' => '0', 'type' => 'cleaningFee', 'created_at' => Carbon::now()->toDateTimeString(), 'updated_at' => Carbon::now()->toDateTimeString()],
        ['month' => 'jul', 'price' => '0', 'type' => 'cleaningFee', 'created_at' => Carbon::now()->toDateTimeString(), 'updated_at' => Carbon::now()->toDateTimeString()],
        ['month' => 'aug', 'price' => '0', 'type' => 'cleaningFee', 'created_at' => Carbon::now()->toDateTimeString(), 'updated_at' => Carbon::now()->toDateTimeString()],
        ['month' => 'sep', 'price' => '0', 'type' => 'cleaningFee', 'created_at' => Carbon::now()->toDateTimeString(), 'updated_at' => Carbon::now()->toDateTimeString()],
        ['month' => 'oct', 'price' => '0', 'type' => 'cleaningFee', 'created_at' => Carbon::now()->toDateTimeString(), 'updated_at' => Carbon::now()->toDateTimeString()],
        ['month' => 'nov', 'price' => '0', 'type' => 'cleaningFee', 'created_at' => Carbon::now()->toDateTimeString(), 'updated_at' => Carbon::now()->toDateTimeString()],
        ['month' => 'dec', 'price' => '0', 'type' => 'cleaningFee', 'created_at' => Carbon::now()->toDateTimeString(), 'updated_at' => Carbon::now()->toDateTimeString()]
      ];

      DB::table('prices_each_month')->insert($data);
    }
}
