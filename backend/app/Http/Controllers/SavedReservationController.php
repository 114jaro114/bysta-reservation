<?php

namespace App\Http\Controllers;

use App\Models\SavedReservation;
use App\Models\SavedReservationUserContactInfo;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Events\SavedReservations;

class SavedReservationController extends Controller
{
    //get reservations
    public function index()
    {
        $savedReservation = SavedReservation::with('usermodel', 'usercontactmodel')->where('user_id', '=', auth()->user()->id)->get();
        return response()->json($savedReservation);
    }

    //make reservation
    public function store(Request $request)
    {
        $data = $request->data;

        $savedReservation = SavedReservation::Create([
            'user_id' => $data['user_id'],
            'username' => $data['username'],
            'event_name' => $data['event_name'],
            'start_date' => $data['start_date'],
            'end_date' => $data['end_date'],
            'start_time' => $data['start_time'],
            'end_time' => $data['end_time'],
            'nights' => $data['nights'],
            'adults' => $data['adults'],
            'childs_2_to_12' => $data['childs_2_to_12'],
            'childs_to_2' => $data['childs_to_2'],
            'cleaning_fee' => $data['cleaning_fee'],
            'price_for_night' => $data['price_for_night'],
            'total_persons' => $data['total_persons'],
            'overall_price' => $data['overall_price'],
            'seen_changes_user' => '0'
        ]);

        $data2 = $request->data2;
        $phone = $data2['phone'];
        SavedReservationUserContactInfo::Create([
          'saved_reservation_id' => strval($savedReservation['id']),
          'user_id' => strval($savedReservation['user_id']),
          'surname' => $data2['surname'],
          'lastname' => $data2['lastname'],
          'address' => $data2['address'],
          'city' => $data2['city'],
          'postcode' => $data2['postcode'],
          'country' => $data2['country'],
          'phone'  => $phone['number']
        ]);

        broadcast(new SavedReservations($savedReservation, auth()->user()->id, 'created'));

        return response()->json();
    }

    //delete saved reservation
    public function delete(Request $request)
    {
        $savedReservation = SavedReservation::where('id', $request->id)->get();

        SavedReservation::where('id', $request->id)->delete();
        SavedReservationUserContactInfo::where('saved_reservation_id', $request->id)->delete();

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
    // public function savedReservationSavedUserContactInfo(Request $request) {
    //   $data = $request->data;
    //   $res_id = $request->saved_reservation_id;
    //   $user_id = $request->user_id;
    //   $test = SavedReservationUserContactInfo::updateOrCreate([
    //     'saved_reservation_id' => $res_id,
    //     'user_id' => $user_id,
    //     'surname' => $data['surname'],
    //     'lastname' => $data['lastname'],
    //     'address' => $data['address'],
    //     'city' => $data['city'],
    //     'postcode' => $data['postcode'],
    //     'country' => $data['country'],
    //     'phone'  => $data['phone']
    //   ]);
    //
    //   return response()->json($res_id);
    // }
}
