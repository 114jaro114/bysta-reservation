<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Events\Reservations;

class ReservationController extends Controller
{
    //get reservations
    public function index()
    {
        $username = auth()->user()->name;
        if ($username == 'admin') {
            return DB::table('reservations')->get();
        } else {
            return DB::table('reservations')->where('username', '=', $username)->get();
        }
    }

    //make reservation
    public function store(Request $request)
    {
        Reservation::create([
            'event_name' => $request->event_name,
            'user_id' =>$request->user_id,
            'username' => $request->username,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'nights' => $request->nights,
            'adults' => $request->adults,
            'childs_2_to_12' => $request->childs2to12,
            'childs_to_2' => $request->childsto2,
            'cleaning_fee' => $request->cleaningFee,
            'price_for_night' => $request->priceForNight,
            'total_persons' => $request->totalPersons,
            'overall_price' => $request->overallPrice,
            'note' => $request->note
        ]);

        $reservation = DB::table('reservations')->where('start_date', $request->start_date)->get();

        broadcast(new Reservations($reservation, '1', 'created'));
        // $new_calendar = Reservation::create($request->all());
        return response()->json($reservation);
    }

    //update reservation
    public function update(Request $request)
    {
        $updateDetails = [
            'event_name' => $request->event_name,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'seen_changes_user' => '0'
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

        broadcast(new Reservations($reservation, $user_id[0]->id, 'updated'));

        return response()->json($reservation);
    }

    //delete reservation
    public function delete(Request $request)
    {
        $user_id = Reservation::where('id', $request->id)
                     ->select('user_id')
                     ->get();

        $reservation = Reservation::where('id', $request->id)->get();

        broadcast(new Reservations($reservation, $user_id[0]->user_id, 'deleted'));

        Reservation::where('id', $request->id)->delete();

        return response($reservation);
    }

    public function checkPendingReservation($username)
    {
        return Reservation::where([['username', '=', $username],['event_name', '=', 'rezervácia']])->count();
    }

    public function getUncheckedReservationsUser()
    {
        // get all reservations for user
        if (auth()->user()->id == '1') {
          $allUncheckedReservations = Reservation::where('seen_changes_admin', '=', '0')->count();
        } else {
          $allUncheckedReservations = Reservation::where([['user_id', '=', auth()->user()->id], ['seen_changes_user', '=', '0']])->count();
        }

        return response()->json($allUncheckedReservations);
    }

    public function markAsRead()
    {
        if (auth()->user()->id == '1') {
          Reservation::where('seen_changes_admin', '0')->update(['seen_changes_admin' => '1']);

          return response()->json("successfully updated reservations status admin");
        } else {
          Reservation::where('seen_changes_user', '0')->update(['seen_changes_user' => '1']);
          return response()->json("successfully updated reservations status user");
        }
    }
}
