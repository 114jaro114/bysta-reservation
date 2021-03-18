<?php

use Illuminate\Support\Facades\Broadcast;

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

Broadcast::channel('messages.{id}', function ($user, $id) {
    return $user->id === (int) $id;
});

// Broadcast::channel('statusUpdate', function ($user) {
//     return $user;
// });
//channel for Notifications
Broadcast::channel('notif-channel', function ($user) {
    return $user;
});
// This is only for testing purposes
Broadcast::channel('pchat', function ($user) {
    return $user;
});

// Broadcast::channel('pchat', function ($user) {
//     return auth()->$user->name;
// });
//
// Broadcast::channel('comment-channel', function () {
//     return true;
// });
