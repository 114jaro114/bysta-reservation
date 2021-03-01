<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RatingController;
use App\Http\Controllers\CalendarController;
use App\Http\Controllers\ContactsController;
use App\Http\Controllers\UserAvatarController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\FriendshipsController;
use App\Http\Controllers\ValidateRegisterLogin;
use App\Traits\Friendable;
use App\Models\User;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::group(['prefix' => 'internal', 'middleware' => ['jwt.verify','admin']], function(){
//     Route::get('sockets/serve', function(){
//         \Illuminate\Support\Facades\Artisan::call('websockets:serve');
//     });
// });

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix' => 'internal', 'middleware' => ['auth:api']], function () {
    Route::get('sockets/serve', function () {
        \Illuminate\Support\Facades\Artisan::call('websockets:serve');
    });
});

// Route::post('/broadcast', function (Request $request) {
//     $pusher = new Pusher\Pusher(env('PUSHER_APP_KEY'), env('PUSHER_APP_SECRET'), env('PUSHER_APP_ID'));
//     // return $pusher->socket_auth($request->request->get('channel_name'), $request->request->get('socket_id'));
//     // console.log($request);
//     // return $pusher->presence_auth($request->request->get('channel_name'), $request->request->get('socket_id'), $request->request->user()->id, $request->request->text);
// });

Route::post('/broadcast', function (Request $request) {
    $pusher = new Pusher\Pusher(
        env('PUSHER_APP_KEY'),
        env('PUSHER_APP_SECRET'),
        env('PUSHER_APP_ID'),
        array(
        'cluster' => env('PUSHER_APP_CLUSTER'),
        'useTLS' => false,
        'host' => '127.0.0.1',
        'port' => 6001,
        'scheme' => 'http',
        )
    );
    return $pusher->presence_auth($request->request->get('channel_name'), $request->request->get('socket_id'), $request->contact_id, $request->text);
    // return $pusher->socket_auth($request->request->get('channel_name'), $request->request->get('socket_id'));
});

Route::post('/auth/register', [AuthController::class, 'register']);
Route::post('/auth/login', [AuthController::class, 'login']);
Route::get('/auth/user', [AuthController::class, 'me']);
Route::post('/auth/logout', [AuthController::class, 'logout']);

Route::get('/checkIfUsernameExist/{name}', [ValidateRegisterLogin::class, 'checkUsername']);
Route::post('/checkIfEMailExist', [ValidateRegisterLogin::class, 'checkEmail']);

Route::get('/calendar', [CalendarController::class, 'index']);
Route::post('/calendar/store', [CalendarController::class, 'store']);
Route::post('/calendar/update', [CalendarController::class, 'update']);
Route::post('/calendar/delete', [CalendarController::class, 'destroy']);

Route::get('/rating', [RatingController::class, 'index']);
Route::post('/rating/store', [RatingController::class, 'store']);
Route::post('/rating/update', [RatingController::class, 'update']);

Route::get('/contacts', [ContactsController::class, 'index']);
Route::get('/conversation/{id}', [ContactsController::class, 'getMessagesFor']);
Route::post('/conversation/send', [ContactsController::class, 'send']);
//show Profile
Route::get('/profile/{user_id}', [ContactsController::class, 'getUserProfile']);
//get all own friends
Route::get('/friends', [ContactsController::class, 'friends']);
//upload avatar
Route::post('/upload_avatar', [UserAvatarController::class, 'upload_user_photo']);

//comment system
// Route::get('/', 'CommentController@index');
Route::get('/comment', [CommentController::class, 'index']);
Route::get('/comments', [CommentController::class, 'fetchComments']);
Route::post('/comments', [CommentController::class, 'store']);

//Friendships
Route::get('/friendships', [FriendshipsController::class, 'getFriendships']);
Route::get('/getAllPossibleFriends', [FriendshipsController::class, 'getAllPossibleFriends']);
Route::post('/friendships/sendFriendshipRequest', [FriendshipsController::class, 'sendFriendshipRequest']);
Route::post('/friendships/acceptFriendshipRequest', [FriendshipsController::class, 'acceptFriendshipRequest']);
Route::post('/friendships/removeFromFriendshipList', [FriendshipsController::class, 'removeFromFriendshipList']);
// contact form
Route::post('/contactForm', [FriendshipsController::class, 'contactForm']);
Route::get('/getContactForm', [FriendshipsController::class, 'getContactForm']);

//
// Route::get('test', function () {
//     event(new App\Events\Test());
//     return 'hej';
// });


//Traits
Route::get('/check_relationship_status/{id}', [FriendshipsController::class, 'check']);
Route::get('/add_friend/{id}', [FriendshipsController::class, 'add_friend']);
Route::get('/accept_friend/{id}', [FriendshipsController::class, 'accept_friend']);
