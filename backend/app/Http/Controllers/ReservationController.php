<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class ReservationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Reservation::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $reservation = Reservation::create([
          'event_name' => $request->event_name,
          'username' => $request->username,
          'start_date' => $request->start_date,
          'end_date' => $request->end_date,
          'start_time' => $request->start_time,
          'end_time' => $request->end_time,
          'nights' => $request->nights,
          'adults' => $request->adults,
          'childs2to12' => $request->childs2to12,
          'childsto2' => $request->childsto2,
          'priceForNight' => $request->priceForNight,
          'overallPriceForNight' => $request->overallPriceForNight,
      ]);
        // $new_calendar = Reservation::create($request->all());
        return response()->json($reservation);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Calendar  $calendar
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        // $event_name = $request->event_name;
        // $start_date = $request->start_date;
        // $end_date = $request->end_date;
        // $start_time = $request->start_time;
        // $end_time = $request->end_time;
        //
        // $nights = $request->nights;
        // $adults = $request->adults;
        // $childs2to12 = $request->childs2to12;
        // $childsto2 = $request->childsto2;
        // $priceForNight = $request->priceForNight;
        // $overallPriceForNight = $request->overallPriceForNight;
        // DB::update(
        //     'update reservations set
        //             event_name = ?, start_date = ?, end_date = ?,
        //             start_time = ?, end_time = ?, nights = ?,
        //             adults = ?, childs2to12 = ?, childsto2 = ?,
        //             priceForNight = ?, overallPriceForNight = ?
        //             where username = ?',
        //     [$event_name, $start_date, $end_date,
        //              $start_time, $end_time, $nights,
        //              $adults, $childs2to12, $childsto2,
        //              $priceForNight, $overallPriceForNight, $request->username]
        // );

        $updateDetails = [
            'event_name' => $request->event_name,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
        ];
        $updateReservation = DB::table('reservations')
                               ->where('id', $request->id)
                               ->update($updateDetails);
        // ->update(
        //     [
        //      'start_date', '=', $start_date,
        //     'end_date', '=', $end_date,
        //     'event_name', '=', $event_name
        //   ]
        // );
        return response()->json([
            'message' => 'Successfully updated event!'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        Reservation::where('id', $request->id)->delete();
        // $calendar->delete();
        return response('Event removed successfully!');
    }
}
