<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

use App\Models\User;

class UpdateAccountSettingsController extends Controller
{
    public function updateAccountSettings(Request $request) {
      $a = 'no';
      $a1 = 'no';
      $a2 = 'no';
      if ($request->name != auth()->user()->name) {
        $a = 'Name was successfully changed!';
        User::where('id', auth()->user()->id)->update(['name' => $request->name]);
      }

      if ($request->email != auth()->user()->email) {
        $a1 = 'Email was successfully changed!';
        User::where('id', auth()->user()->id)->update(['email' => $request->email]);
      }

      if ($request->password) {
        $a2 = 'Password was successfully changed!';
        User::where('id', auth()->user()->id)->update(['password' => Hash::make($request->password)]);
      }
      return response()->json([
        'name' => $a,
        'email' => $a1,
        'pass' => $a2
      ]);
    }
}
