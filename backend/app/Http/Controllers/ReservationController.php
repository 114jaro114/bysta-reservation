<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Events\Reservations;

class ReservationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $username = auth()->user()->name;
        if ($username == 'admin') {
            return DB::table('reservations')->get();
        // return Reservation::all();
        } else {
            // $checkIfReservationExist = DB::table('reservations')
            //   ->where('username', '=', auth()->user()->name)
            //   ->first();
            // if ($checkIfReservationExist) {
            return DB::table('reservations')->where('username', '=', $username)->get();
            // }
        }
    }

    // public function getAuthReservation()
    // {
    //     return Reservation::where('user_id', auth()->user()->id)->get();
    // }

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
          'user_id' =>$request->user_id,
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
          'note' => $request->note
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

        $username = Reservation::where('id', $request->id)
                       ->select('username')
                       ->get();

        $user_id = DB::table('users')
                     ->where('name', $username[0]->username)
                     ->select('id')
                     ->get();

        $reservation = DB::table('reservations')->where('id', $request->id)->get();

        broadcast(new Reservations($reservation));

        return response()->json($reservation);
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

    public function checkPendingReservation($username)
    {
        return Reservation::where([['username', '=', $username],['event_name', '=', 'rezervácia']])->count();
    }
}
