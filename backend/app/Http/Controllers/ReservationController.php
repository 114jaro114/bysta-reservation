<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Models\ReservationUserContactInfo;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Events\Reservations;
use App\Events\AllUsedReservationDates;

use Carbon\Carbon;
use Carbon\CarbonPeriod;

class ReservationController extends Controller
{

    public function allReservations() {
      $reserv = Reservation::get();
      return response()->json($reserv);
    }

    //get concrete reservations
    public function getReservationsForUser() {
        $username = auth()->user()->name;
        if ($username == 'admin') {
          // return DB::table('reservations')->get();
          $reserv = Reservation::with('usermodel', 'usercontactmodel')->get();
          return response()->json($reserv);
        } else {
          $reserv = Reservation::with('usermodel', 'usercontactmodel')->where('username', '=', $username)->get();
          return response()->json($reserv);
          // return DB::table('reservations')->where('username', '=', $username)->get();
        }
    }

    //make reservation
    public function store(Request $request) {
        $data = Reservation::create([
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

        $userInfoData = ReservationUserContactInfo::create([
          'reservation_id' => $data['id'],
          'user_id' => $data['user_id'],
          'surname' => $request->surname,
          'lastname' => $request->lastname,
          'address' => $request->address,
          'city' => $request->city,
          'postcode' => $request->postcode,
          'country' => $request->country,
          'phone' => $request->phone,
        ]);

        broadcast(new Reservations($data, '1', 'created'));

        $period = CarbonPeriod::create($request->start_date, $request->end_date);
        $dates = $period->toArray();
        broadcast(new AllUsedReservationDates($dates));

        return response()->json();
    }

    private function generateDateRange(Carbon $start_date, Carbon $end_date) {
        $dates = [];

        for($date = $start_date->copy(); $date->lte($end_date); $date->addDay()) {
            $dates[] = $date->format('Y-m-d');
        }

        return $dates;
    }

    //update reservation
    public function update(Request $request)
    {
        $data = $request->data;
        $dataContact = $data['usercontactmodel'];
        // $country = $dataContact['country'];
        $updateReservation = [
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
        ];

        $updateReservationUserContactInfo = [
            'surname' => $dataContact['surname'],
            'lastname' => $dataContact['lastname'],
            'address' => $dataContact['address'],
            'city' => $dataContact['city'],
            'postcode' => $dataContact['postcode'],
            'country' => $dataContact['country'],
            'phone'  => $dataContact['phone']
        ];

        DB::table('reservations')->where('id', $data['id'])->update($updateReservation);

        DB::table('reservations_user_contact_info')->where('reservation_id', $data['id'])->update($updateReservationUserContactInfo);

        $username = Reservation::where('id', $data['id'])
                       ->select('username')
                       ->get();

        $user_id = DB::table('users')
                     ->where('name', $username[0]->username)
                     ->select('id')
                     ->get();

        $reservation = Reservation::with('usermodel', 'usercontactmodel')->where('id', $data['id'])->get();

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
        ReservationUserContactInfo::where('reservation_id', $request->id)->delete();

        broadcast(new Reservations($reservation, $user_id[0]->user_id, 'deleted'));

        Reservation::where('id', $request->id)->delete();

        return response($reservation);
    }

    public function checkPendingReservation($username)
    {
        return Reservation::where([['username', '=', $username],['event_name', '=', 'rezerv??cia']])->count();
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

    // reservation user contanct inform??cie

    public function reservationUserContactInfo(Request $request) {
      $reservation = ReservationUserContactInfo::create([
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

      return response()->json($reservation);
    }

    public function getAllUsedReservationsDates() {
      $allConvertedDates = [];
      $allDates = Reservation::select('start_date', 'end_date')->get();
      for ($i=0; $i < count($allDates); $i++) {
        $period = CarbonPeriod::create($allDates[$i]->start_date, $allDates[$i]->end_date);
        for ($x=0; $x < count($period->toArray()); $x++) {
          array_push($allConvertedDates, $period->toArray()[$x]);
        }
      }

      return response()->json($allConvertedDates);
    }
}
