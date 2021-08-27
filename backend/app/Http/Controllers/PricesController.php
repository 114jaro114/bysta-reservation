<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Prices;
use App\Models\PricesEachMonth;
use Carbon\Carbon;

class PricesController extends Controller
{
    public function updatePricesForEachMonth(Request $request) {
      for($j=0; $j < count($request->pricesFor) ; $j++) {
        for($i=0; $i < count($request->selected) ; $i++) {
          if (PricesEachMonth::where([['month', '=', $request->selected[$i]],
                                      ['type', '=', $request->pricesFor[$j]]
                                    ])->exists()) {
            DB::table('prices_each_month')
            ->where([['month', '=', $request->selected[$i]],
                     ['type', '=', $request->pricesFor[$j]]
                   ])
            ->update(['price' => $request->price,
                      'created_at' => Carbon::now()->toDateTimeString(),
                      'updated_at' => Carbon::now()->toDateTimeString()
                    ]);
          } else {
            DB::table('prices_each_month')->insert([
              'month' => $request->selected[$i],
              'price' => $request->price,
              'type' => $request->pricesFor[$j],
              'created_at' => Carbon::now()->toDateTimeString(),
              'updated_at' => Carbon::now()->toDateTimeString()
            ]);
          }
        }
      }
      return response()->json("ok");
    }

    public function getPricesForEachMonth() {

      $LastDate = DB::table('prices_each_month')->select('created_at')->orderBy('created_at', 'desc')->first();
      $data = DB::table('prices_each_month')
      ->select('price')
      ->get();

      $array = array();
      $array[] = array(
        'price' => $data,
        'created_at' => $LastDate
      );

      return response()->json($array);
    }

    public function getPricesForGraph() {

      $LastDate = DB::table('prices_each_month')->select('created_at')->orderBy('created_at', 'desc')->first();
      $data = DB::table('prices_each_month')
      ->where('type', '=', 'adults')
      ->select('price')
      ->get();

      $data2 = DB::table('prices_each_month')
      ->where('type', '=', 'child_from_2_to_12')
      ->select('price')
      ->get();

      $data3 = DB::table('prices_each_month')
      ->where('type', '=', 'child_to_2')
      ->select('price')
      ->get();

      $data4 = DB::table('prices_each_month')
      ->where('type', '=', 'cleaningFee')
      ->select('price')
      ->get();

      $array = array();
      $array[] = array(
        'adults' => $data,
        'child_from_2_to_12' => $data2,
        'child_to_2' => $data3,
        'cleaningFee' => $data4,
        'created_at' => $LastDate
      );

      return response()->json($array);
    }




}
