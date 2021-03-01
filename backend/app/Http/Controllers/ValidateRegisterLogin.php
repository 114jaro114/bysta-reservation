<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class ValidateRegisterLogin extends Controller
{
    public function checkUsername($name)
    {
        $usernameExist = DB::table('users')
            ->where('name', 'LIKE', $name)
            ->first();

        if ($usernameExist) {
            return response('Zadané meno je už použité');
        }
        // return response('OK');
    }

    public function checkEmail(Request $request)
    {
        $emailExist = DB::table('users')
          ->where('email', 'LIKE', $request->email)
          ->first();

        if ($emailExist) {
            return response('Zadaný email je už použitý');
        }
        // return response('This email dont exist');
    }
}
