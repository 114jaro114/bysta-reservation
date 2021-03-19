<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Message;
use App\Events\NewMessage;

use App\Models\Friendship;
use Illuminate\Support\Facades\DB;

class ContactsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {

        // $contacts = User::where('id', '!=', auth()->user()->id)->get();
        $array1 = array();
        $alreadyFriends1 = DB::table('friendships')
                           ->where([
                             ['requester', '=', auth()->user()->id],
                             ['friendship_status', '=', '1']
                           ])
                           ->select('user_requested')
                           ->get();
        foreach ($alreadyFriends1 as $row1):
       $test = DB::table('users')
                 ->where("users.id", $row1->user_requested)
                 ->select('users.id')
                 ->get();
        $array1[] = array(
         'id' => $test[0]->id,
        );
        endforeach;

        $array2 = array();
        $alreadyFriends2 = DB::table('friendships')
                           ->where([
                             ['user_requested', '=', auth()->user()->id],
                             ['friendship_status', '=', '1']
                           ])
                           ->select('requester')
                           ->get();
        foreach ($alreadyFriends2 as $row2):
          $test2 = DB::table('users')
                    ->where("users.id", $row2->requester)
                    ->select('users.id')
                    ->get();
        $array2[] = array(
        'id' => $test2[0]->id,
        );
        endforeach;

        $friendsAll = array_merge($array1, $array2);
        $contacts = DB::table('users')
        ->whereIn('id', $friendsAll)
        ->select('users.id', 'users.name', 'users.email', 'users.status', 'users.avatar', 'users.created_at')
        ->get();

        $unreadIds = Message::select(\DB::raw('`from` as sender_id, count(`from`) as messages_count'))
          ->where('to', auth()->user()->id)
          ->where('read', false)
          ->groupBy('from')
          ->get();

        $contacts = $contacts->map(function ($contact) use ($unreadIds) {
            $contactUnread = $unreadIds->where('sender_id', $contact->id)->first();
            $contact->unread = $contactUnread ? $contactUnread->messages_count : 0;
            return $contact;
        });
        return response()->json($contacts);
    }

    public function getAllUnreadMessages()
    {
        $allUnreadMessages = DB::table('messages')->where([['to', '=', auth()->user()->id],['read', '=', false]])->count();
        // broadcast(new UnreadMessages($allUnreadMessages))->toOthers();
        return response()->json($allUnreadMessages);
    }

    public function getMessagesFor($id)
    {
        // mark all messages with the selected contact as read
        Message::where('from', $id)->where('to', auth()->user()->id)->update(['read' => true]);

        // get all messages between the authenticated user and the selected user
        $messages = Message::where(function ($q) use ($id) {
            $q->where('from', auth()->user()->id);
            $q->where('to', $id);
        })->orWhere(function ($q) use ($id) {
            $q->where('from', $id);
            $q->where('to', auth()->user()->id);
        })
        ->get();

        return response()->json($messages);
    }

    public function send(Request $request)
    {
        $message = Message::create([
            'from' => auth()->user()->id,
            'to' => $request->contact_id,
            'text' => $request->text
        ]);

        $allUnreadMessages = DB::table('messages')->where([['to', '=', $request->contact_id],['read', '=', false]])->count();
        Message::orderBy('id', 'desc')->first()->update(['totalUnreadMsgTo' => $allUnreadMessages]);

        broadcast(new NewMessage($message->load('fromContact')))->toOthers();

        return response()->json($message);
    }

    public function users()
    {
        return User::all();
    }
}
