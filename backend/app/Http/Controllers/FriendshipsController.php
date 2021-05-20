<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Friendship;
use App\Models\User;
use Illuminate\Support\Facades\DB;

use App\Traits\Friendable;

class FriendshipsController extends Controller
{
    public function getFriendships()
    {
        $friends = array();
        $f1 = DB::table('friendships')->where('requester', auth()->user()->id)
                    ->select('friendship_status', 'requester', 'user_requested')
                    ->get();
        // $f1 = Friendship::where('requester', auth()->user()->id)
        //             ->get();
        foreach ($f1 as $friendship):
          $test = DB::table('users')
                    // ->join('friendships', 'users.id', '=', 'friendships.user_requested')
                    ->where("users.id", $friendship->user_requested)
                    ->select('users.id', 'users.name', 'users.email', 'users.status', 'users.avatar', 'users.created_at')
                    ->get();
        // , 'friendships.requester', 'friendships.friendship_status', 'friendships.user_requested'
        $friends[] = array(
            'id' => $test[0]->id,
            'name' => $test[0]->name,
            'email' => $test[0]->email,
            'status' => $test[0]->status,
            'avatar' => $test[0]->avatar,
            'created_at' => $test[0]->created_at,
            'friendship_status' => $friendship->friendship_status,
            'requester' => $friendship->requester,
            'user_requested' => $friendship->user_requested
          );
        // array_push($friends, User::find($friendship->user_requested));
        endforeach;


        $friends2 = array();
        $f2 = DB::table('friendships')->where('user_requested', auth()->user()->id)
                    ->select('friendship_status', 'requester', 'user_requested')
                    ->get();
        // $f1 = Friendship::where('user_requested', auth()->user()->id)
        //             ->get();
        foreach ($f2 as $friendship2):
            $test2 = DB::table('users')
                      // ->join('friendships', 'users.id', '=','friendships.')
                      ->where("users.id", $friendship2->requester)
                      ->select('users.id', 'users.name', 'users.email', 'users.status', 'users.avatar', 'users.created_at')
                      ->get();
        // , 'friendships.requester', 'friendships.friendship_status', 'friendships.user_requested'
        $friends2[] = array(
              'id' => $test2[0]->id,
              'name' => $test2[0]->name,
              'email' => $test2[0]->email,
              'status' => $test2[0]->status,
              'avatar' => $test2[0]->avatar,
              'created_at' => $test2[0]->created_at,
              'friendship_status' => $friendship2->friendship_status,
              'requester' => $friendship2->requester,
              'user_requested' => $friendship2->user_requested
            );
        // // array_push($friends, User::find($friendship->requester));
        endforeach;

        $friendsAll = array_merge($friends, $friends2);
        return response()->json($friendsAll);
    }

    public function sendFriendshipRequest(Request $request)
    {
        // print_r($request);
        if (Friendship::where('requester', '=', auth()->user()->id)->where('user_requested', '=', $request->user_requested)->exists()) {
            return response()->json('uz existuje');
        } elseif (Friendship::where('requester', '=', $request->user_requested)->where('user_requested', '=', auth()->user()->id)->exists()) {
            return response()->json('uz existuje2');
        } else {
            $friendships = Friendship::create([
              'requester' => auth()->user()->id,
              'user_requested' => $request->user_requested,
              'friendship_status' => $request->friendship_status
          ]);
        }
        return response()->json($friendships);
    }

    public function acceptFriendshipRequest(Request $request)
    {
        $friendships = DB::table('friendships')
                         ->where('requester', '=', $request->requester)
                         ->where('user_requested', '=', auth()->user()->id)
                         ->update(['friendship_status' => $request->friendship_status]);
        return response()->json($friendships);
    }

    public function removeFromFriendshipList(Request $request)
    {
        DB::table('friendships')
        ->where([
                ['requester', '=', $request->requester],
                ['user_requested', '=', $request->user_requested]
        ])
         ->delete();
        return response()->json($request);
    }


    public function getAllPossibleFriends()
    {
        $array1 = array();
        $alreadyFriends1 = DB::table('friendships')->where('requester', auth()->user()->id)
                             // ->select('user_requested')
                             ->select('friendship_status', 'requester', 'user_requested')
                             ->get();
        foreach ($alreadyFriends1 as $row1):
         $test = DB::table('users')
                   ->where("users.id", $row1->user_requested)
                   ->select('users.id', 'users.name', 'users.email', 'users.status', 'users.avatar', 'users.created_at')
                   ->get();
        $array1[] = array(
           'id' => $test[0]->id,
           // 'friendship_status' => $alreadyFriends1->friendship_status,
           // 'requester' => $alreadyFriends1->requester,
           // 'user_requested' => $alreadyFriends1->user_requested
         );
        endforeach;

        $array2 = array();
        $alreadyFriends2 = DB::table('friendships')->where('user_requested', auth()->user()->id)
                             // ->select('requester')
                             ->select('friendship_status', 'requester', 'user_requested')
                             ->get();
        foreach ($alreadyFriends2 as $row2):
            $test2 = DB::table('users')
                      ->where("users.id", $row2->requester)
                      ->select('users.id', 'users.name', 'users.email', 'users.status', 'users.avatar', 'users.created_at')
                      ->get();
        $array2[] = array(
          'id' => $test2[0]->id,
          // 'friendship_status' => $alreadyFriends2->friendship_status,
          // 'requester' => $alreadyFriends2->requester,
          // 'user_requested' => $alreadyFriends2->user_requested
        );
        endforeach;

        $friendsAll = array_merge($array1, $array2);
        //no me
        $friendsAll[] = array(
          'id' => auth()->user()->id,
        );
        $allUsersWithoutFriends = DB::table('users')
          ->whereNotIn('id', $friendsAll)
          ->select('users.id', 'users.name', 'users.email', 'users.status', 'users.avatar', 'users.created_at')
          ->get();


        ///////////////////////////////////
        // $array3 = array();
        // foreach ($allUsersWithoutFriends as $row3):
        //         $skuska = DB::table('friendships')
        //                   ->where('requester', '=', $row3->id)
        //                   ->orWhere('requester', '=', $row3->id)
        //                    // ->select('user_requested')
        //                   ->select('friendship_status', 'requester', 'user_requested')
        //                   ->get();
        // if ($skuska != null) {
        //     $array3[] = array(
        //     'id' => $row3->id,
        //     'name' => $row3->name,
        //     'email' => $row3->email,
        //     'status' => $row3->status,
        //     'avatar' => $row3->avatar,
        //     'created_at' => $row3->created_at,
        //     'friendship_status' => $skuska[0]->friendship_status,
        //     'requester' => $skuska[0]->requester,
        //     'user_requested' => $skuska[0]->user_requested
        //     // 'friendship_status' => $alreadyFriends2->friendship_status,
        //     // 'requester' => $alreadyFriends2->requester,
        //     // 'user_requested' => $alreadyFriends2->user_requested
        //   );
        // }
        // endforeach;
        return response()->json($allUsersWithoutFriends);
    }

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
