<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\OAuthController;
use App\Http\Controllers\RatingController;
use App\Http\Controllers\CalendarController;
use App\Http\Controllers\ContactsController;
use App\Http\Controllers\MessengerController;
use App\Http\Controllers\UserAvatarController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\FriendshipsController;
use App\Http\Controllers\ValidateRegisterLogin;
use App\Http\Controllers\NotificationsController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\SavedReservationController;
use App\Http\Controllers\PricesController;
use App\Http\Controllers\UserContactController;
use App\Http\Controllers\PostsController;


use App\Http\Controllers\UpdateAccountSettingsController;
use App\Traits\Friendable;
use App\Models\User;


use App\Http\Controllers\TestController;
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

// Route::group(['prefix' => 'internal', 'middleware' => ['auth:api']], function () {
//     Route::get('sockets/serve', function () {
//         \Illuminate\Support\Facades\Artisan::call('websockets:serve');
//     });
// });

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
        // 'host' => '', //127.0.0.1
        'host' => '192.168.1.118',
        'port' => 6001,
        'scheme' => 'http',
        )
    );
    return $pusher->presence_auth($request->request->get('channel_name'), $request->request->get('socket_id'), $request->contact_id);
    // return $pusher->presence_auth($request->request->get('channel_name'), $request->request->get('socket_id'), $request->contact_id, $request->text);
    // return $pusher->socket_auth($request->request->get('channel_name'), $request->request->get('socket_id'));
});

Route::post('/auth/register', [AuthController::class, 'register']);
Route::post('/auth/login', [AuthController::class, 'login']);
Route::get('/auth/user', [AuthController::class, 'me']);
Route::post('/auth/logout', [AuthController::class, 'logout']);

// Send reset password mail
Route::post('/auth/reset-password', [AuthController::class, 'sendPasswordResetLink']);
// handle reset password form process
Route::post('/auth/reset/password', [AuthController::class, 'callResetPassword']);
// handle activate account form process
Route::post('/auth/verification/account', [AuthController::class, 'callVerificationAccount']);

Route::get('/user/{id}', [ContactsController::class, 'getUserById']);

//update account settings
Route::post('/updateAccountSettings', [UpdateAccountSettingsController::class, 'updateAccountSettings']);

Route::post('/checkIfUsernameExist', [ValidateRegisterLogin::class, 'checkUsername']);
Route::post('/checkIfEMailExist', [ValidateRegisterLogin::class, 'checkEmail']);

Route::get('/calendar', [CalendarController::class, 'index']);
Route::post('/calendar/store', [CalendarController::class, 'store']);
Route::post('/calendar/update', [CalendarController::class, 'update']);
Route::post('/calendar/delete', [CalendarController::class, 'destroy']);

//reservations
Route::get('/allReservation', [ReservationController::class, 'allReservations']);
Route::get('/reservation', [ReservationController::class, 'getReservationsForUser']);
Route::get('/checkPendingReservation/{username}', [ReservationController::class, 'checkPendingReservation']);
Route::post('/reservation/store', [ReservationController::class, 'store']);
Route::post('/reservation/update', [ReservationController::class, 'update']);
Route::post('/reservation/delete', [ReservationController::class, 'delete']);
Route::post('/reservation/markAsRead', [ReservationController::class, 'markAsRead']);
Route::get('/reservation/getUncheckedReservationsUser', [ReservationController::class, 'getUncheckedReservationsUser']);
Route::post('/reservation/reservationUserContactInfo', [ReservationController::class, 'reservationUserContactInfo']);

Route::get('/reservation/getAllUsedReservationsDates', [ReservationController::class, 'getAllUsedReservationsDates']);


// saved reservation
Route::get('/savedReservation', [SavedReservationController::class, 'index']);
Route::get('/checkPendingSavedReservation/{username}', [SavedReservationController::class, 'checkPendingSavedReservation']);
Route::post('/savedReservation/store', [SavedReservationController::class, 'store']);
Route::post('/savedReservation/delete', [SavedReservationController::class, 'delete']);
Route::post('/savedReservation/markAsRead', [SavedReservationController::class, 'markAsRead']);
Route::get('/savedReservation/getUncheckedSavedReservationsUser', [SavedReservationController::class, 'getUncheckedSavedReservationsUser']);
Route::post('/savedReservation/savedReservationSavedUserContactInfo', [SavedReservationController::class, 'savedReservationSavedUserContactInfo']);

Route::get('/rating', [RatingController::class, 'index']);
Route::post('/rating/store', [RatingController::class, 'store']);
Route::post('/rating/update', [RatingController::class, 'update']);

//Messenger
Route::get('/contacts', [MessengerController::class, 'index']);
Route::get('/conversation/{id}', [MessengerController::class, 'getMessagesFor']);
Route::post('/conversation/send', [MessengerController::class, 'send']);
Route::get('/getAllUnreadMessages', [MessengerController::class, 'getAllUnreadMessages']);
Route::get('/getFewNewestMessages', [MessengerController::class, 'getFewNewestMessages']);
//message reaction add/update and delete
Route::post('/add_message_reaction', [MessengerController::class, 'add_message_reaction']);
Route::post('/delete_message_reaction', [MessengerController::class, 'delete_message_reaction']);

//get user by id
Route::get('/user/{id}', [MessengerController::class, 'getUserById']);
//get user by id 2
Route::get('/user_info/{id}', [AuthController::class, 'getUserInfoById']);
//show Profile
Route::get('/profile/{user_id}', [ContactsController::class, 'getUserProfile']);
//get all own friends
Route::get('/friends', [ContactsController::class, 'friends']);

//upload avatar
Route::post('/upload_avatar', [UserAvatarController::class, 'upload_user_photo']);
Route::post('/delete_avatar', [UserAvatarController::class, 'delete_user_photo']);

//comment system
Route::get('/comment', [CommentController::class, 'index']);
Route::get('/comments', [CommentController::class, 'fetchComments']);
Route::post('/comments', [CommentController::class, 'store']);

//Friendships
Route::get('/friendships', [FriendshipsController::class, 'getFriendships']);
Route::get('/getAllPossibleFriends', [FriendshipsController::class, 'getAllPossibleFriends']);
Route::get('/getAllFriendshipRequests', [FriendshipsController::class, 'getAllFriendshipRequests']);
Route::get('/getCountMyFriendshipRequests', [FriendshipsController::class, 'getCountMyFriendshipRequests']);
Route::post('/friendships/sendFriendshipRequest', [FriendshipsController::class, 'sendFriendshipRequest']);
Route::post('/friendships/acceptFriendshipRequest', [FriendshipsController::class, 'acceptFriendshipRequest']);
Route::post('/friendships/refuseFriendshipRequest', [FriendshipsController::class, 'refuseFriendshipRequest']);
Route::post('/friendships/removeFromFriendshipList', [FriendshipsController::class, 'removeFromFriendshipList']);
Route::get('/getNumberOfFriends', [FriendshipsController::class, 'getNumberOfFriends']);
//Friendships profile
Route::get('/checkIfUserIsMyFriend/{id}', [FriendshipsController::class, 'checkIfUserIsMyFriend']);
Route::get('/friendshipsProfile/{id}', [FriendshipsController::class, 'getFriendshipsProfile']);

// contact form
Route::get('/checkContactForm', [UserContactController::class, 'checkIfContactFormExist']);
Route::post('/contactForm', [UserContactController::class, 'contactForm']);
Route::get('/getContactForm', [UserContactController::class, 'getContactForm']);

//notifications
Route::post('/sendNotification', [NotificationsController::class, 'sendNotification']);
Route::post('/deleteNotification', [NotificationsController::class, 'deleteNotification']);
Route::post('/addToSaved', [NotificationsController::class, 'addToSaved']);
Route::post('/addToAll', [NotificationsController::class, 'addToAll']);
Route::post('/markAsRead', [NotificationsController::class, 'markAsRead']);
Route::get('/getNotification/{id}', [NotificationsController::class, 'getNotification']);
Route::get('/getNotificationAll/{id}', [NotificationsController::class, 'getNotificationAll']);
Route::get('/getNotificationNew/{id}', [NotificationsController::class, 'getNotificationNew']);
Route::get('/getNotificationSaved/{id}', [NotificationsController::class, 'getNotificationSaved']);
Route::get('/getFewNewestNotifications', [NotificationsController::class, 'getFewNewestNotifications']);
Route::get('/getFewOldNotifications', [NotificationsController::class, 'getFewOldNotifications']);
//prices
Route::post('/prices/updatePrices', [PricesController::class, 'updatePrices']);
Route::post('/prices/updatePricesForEachMonth', [PricesController::class, 'updatePricesForEachMonth']);
Route::get('/prices/getPricesForEachMonth', [PricesController::class, 'getPricesForEachMonth']);
Route::get('/prices/getPricesForGraph', [PricesController::class, 'getPricesForGraph']);
Route::get('/prices/getValueSpentByUserForReservation', [PricesController::class, 'getValueSpentByUserForReservation']);


//Traits
Route::get('/check_relationship_status/{id}', [FriendshipsController::class, 'check']);
Route::get('/add_friend/{id}', [FriendshipsController::class, 'add_friend']);
Route::get('/accept_friend/{id}', [FriendshipsController::class, 'accept_friend']);

//social auth
Route::post('/sociallogin/{provider}', [AuthController::class, 'SocialSignup']);
Route::get('/auth/{provider}/callback', [OAuthController::class, 'handleProviderCallback'])->where('provider', '.*');

// apis for posts
//posts add, update, delete, report, get
Route::post('/add_post', [PostsController::class, 'add_post']);
// test img send
Route::post('/add_post_test', [PostsController::class, 'add_post_test']);
//
Route::post('/update_post', [PostsController::class, 'update_post']);
Route::post('/delete_post', [PostsController::class, 'delete_post']);
Route::post('/report_post', [PostsController::class, 'report_post']);

Route::get('/getAllDataAboutPosts/{page}/{perPage}', [PostsController::class, 'getAllDataAboutPosts']);
Route::get('/getAllDataAboutUserPosts/{id}/{page}/{perPage}', [PostsController::class, 'getAllDataAboutUserPosts']);
Route::get('/get_number_of_user_posts', [PostsController::class, 'get_number_of_user_posts']);

//posts_reactions add/update, delete, get
Route::post('/add_post_reaction', [PostsController::class, 'add_post_reaction']);
Route::post('/delete_post_reaction', [PostsController::class, 'delete_post_reaction']);

//posts_shares add/update, delete, get
Route::post('/add_post_share', [PostsController::class, 'add_post_share']);
Route::post('/delete_post_share', [PostsController::class, 'delete_post_share']);

//posts_comments add, update, delete, get
Route::post('/add_post_comment', [PostsController::class, 'add_post_comment']);
//answers_on_comments add, update, delete, get
Route::post('/add_answer_on_comment', [PostsController::class, 'add_answer_on_comment']);
//update, delete, report post comments and answer on post comments
Route::post('/update_post_comment', [PostsController::class, 'update_post_comment']);
Route::post('/delete_post_comment', [PostsController::class, 'delete_post_comment']);
Route::post('/report_post_comment', [PostsController::class, 'report_post_comment']);

//answers_reactions add/update, delete, get
Route::post('/add_comment_reaction', [PostsController::class, 'add_comment_reaction']);
Route::post('/delete_comment_reaction', [PostsController::class, 'delete_comment_reaction']);





// Route::post('sociallogin/{provider}', [AuthController::class, 'SocialSignup']);
// Route::post('auth/{provider}', [OutController::class, 'index'])->where('vue', '.*');
// Route::post('auth/{provider}/callback', [OutController::class, 'index'])->where('vue', '.*');

// Route::post('oauth/{driver}', [OAuthController::class, 'redirect']);
// Route::get('oauth/{driver}/callback', [OAuthController::class, 'handleCallback'])->name('oauth.callback');


// Route::get('/testmail', [TestController::class, 'testmail']);
