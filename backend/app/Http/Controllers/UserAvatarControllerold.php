<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\User;

class UserAvatarController extends Controller
{
    public function upload_user_photo(Request $request)
    {
        // check if image has been received from form
        if ($request->file('avatar')) {
            // check if user has an existing avatar
            if (auth()->user()->avatar != null) {
                // delete existing image file
                Storage::disk('user_avatars')->delete(auth()->user()->avatar);
            }

            // processing the uploaded image
            $avatar_name = auth()->user()->id . '.' . $request->file('avatar')->getClientOriginalExtension();
            $avatar_path = $request->file('avatar')->storeAs('', $avatar_name, 'user_avatars');

            // Update user's avatar column on 'users' table
            $profile = User::find(auth()->user()->id);
            $profile->avatar = $avatar_path;
            User::where('id', auth()->user()->id)->update(['avatar' => $avatar_path]);

            if ($profile->save()) {
                return response()->json([
                    'status'    =>  'success',
                    'message'   =>  'Profile Photo Updated!',
                    'avatar_url'=>  url('storage/user-avatar/'.$avatar_path)
                ]);
            } else {
                return response()->json([
                    'status'    => 'failure',
                    'message'   => 'failed to update profile photo!',
                    'avatar_url'=> null
                ]);
            }
        }

        return response()->json([
            'status'    => 'failure',
            'message'   => 'No image file uploaded!',
            'avatar_url'=> null
        ]);
    }
}
