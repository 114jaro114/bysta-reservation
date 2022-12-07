<?php

namespace App\Http\Controllers;

use App\Models\SavedReservation;
use App\Models\SavedReservationUserContactInfo;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
// use App\Events\Reservations;

class SavedReservationController extends Controller
{
    //get reservations
    public function index()
    {
        $savedReservation = SavedReservation::with('usermodel', 'usercontactmodel')->where('username', '=', auth()->user()->name)->get();
        return response()->json($savedReservation);
    }

    //make reservation
    public function store(Request $request)
    {
        SavedReservation::updateOrCreate([
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

        $savedReservation = DB::table('saved_reservations')->where('start_date', $request->start_date)->get();

        // broadcast(new Reservations($reservation, '1', 'created'));
        return response()->json($savedReservation);
    }

    //delete reservation
    public function delete(Request $request)
    {
        $user_id = SavedReservation::where('id', $request->id)
                     ->select('user_id')
                     ->get();

        $savedReservation = SavedReservation::where('id', $request->id)->get();

        // broadcast(new Reservations($reservation, $user_id[0]->user_id, 'deleted'));

        SavedReservation::where('id', $request->id)->delete();

        return response($savedReservation);
    }

    public function checkPendingSavedReservation($username)
    {
        return SavedReservation::where([['username', '=', $username],['event_name', '=', 'rezervácia']])->count();
    }

    public function getUncheckedSavedReservationsUser()
    {
        // get all reservations for user
        $allUncheckedSavedReservations = SavedReservation::where([['user_id', '=', auth()->user()->id], ['seen_changes_user', '=', '0']])->count();

        return response()->json($allUncheckedSavedReservations);
    }

    public function markAsRead()
    {
        SavedReservation::where('seen_changes_user', '0')->update(['seen_changes_user' => '1']);

        return response()->json("successfully updated reservations status user");
    }

    // reservation user contanct informácie
    public function savedReservationSavedUserContactInfo(Request $request) {
      $savedReservation = SavedReservationUserContactInfo::updateOrCreate([
        'reservation_id' => $request->reservation_id,
        'user_id' => $request->user_id,
        'surname' => $request->surname,
        'lastname' => $request->lastname,
        'address' => $request->address,
        'city' => $request->city,
        'postcode' => $request->postcode,
        'country' => $request->country,
        'phone' => $request->phone,
      ]);

      return response()->json($savedReservation);
    }
}
