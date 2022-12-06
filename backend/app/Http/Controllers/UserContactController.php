<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\UserContact;

class UserContactController extends Controller
{
  public function contactForm(Request $request)
  {
      $surname = $request->surname;
      $lastname =  $request->lastname;
      $address = $request->address;
      $city = $request->city;
      $postcode = $request->postcode;
      $country = $request->country;
      $phone = $request->phone;

      $checker = DB::table('users_contact_info')->select('user_id')->where('user_id', auth()->user()->id)->exists();
      if ($checker) {
          DB::table('users_contact_info')
          ->where('user_id', auth()->user()->id)
          ->update(['surname' => $request->surname,
                    'lastname' => $request->lastname,
                    'address' => $request->address,
                    'city' => $request->city,
                    'postcode' => $request->postcode,
                    'country' => $request->country,
                    'phone' => $request->phone]);
          return response()->json('data boli uspesne aktualizovane');
      } else {
          DB::table('users_contact_info')->insert([
                    'user_id' => auth()->user()->id,
                    'surname' => $request->surname,
                    'lastname' => $request->lastname,
                    'address' => $request->address,
                    'city' => $request->city,
                    'postcode' => $request->postcode,
                    'country' => $request->country,
                    'phone' => $request->phone]);
          return response()->json('data boli uspesne ulozene');
      }
      return response()->json('error');
  }

  public function checkIfContactFormExist()
  {
      $contactFormExist = DB::table('users_contact_info')
        ->where('user_id', '=', auth()->user()->id)
        ->first();

      if ($contactFormExist) {
          return response('1');
      } else {
          return response('0');
      }
  }

  public function getContactForm()
  {
      $getData = DB::table('users_contact_info')->where('user_id', auth()->user()->id)->get();
      return response()->json($getData);
  }
}
