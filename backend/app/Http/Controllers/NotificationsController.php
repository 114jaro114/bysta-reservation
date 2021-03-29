<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Notification;
use App\Events\Notifi;
use Illuminate\Support\Facades\DB;

class NotificationsController extends Controller
{
    public function getNotification($id)
    {
        // get all notifications for user
        $allNotif = Notification::where('to', auth()->user()->id)->get();
        return response()->json($allNotif);
    }
    public function getNotificationAll($id)
    {
        // get all notifications for user
        $allNotif = Notification::where([['to', '=', auth()->user()->id], ['status', '=', 'all']])->get();
        return response()->json($allNotif);
    }

    public function getNotificationNew($id)
    {
        // get all notifications for user
        $allNotif = Notification::where([['to', '=', auth()->user()->id], ['status', '=', 'new']])->get();
        return response()->json($allNotif);
    }

    public function getNotificationRelevant($id)
    {
        // get all notifications for user
        $allNotif = Notification::where([['to', '=', auth()->user()->id], ['status', '=', 'relevant']])->get();
        return response()->json($allNotif);
    }

    public function sendNotification(Request $request)
    {
        $notification = Notification::create([
            'to' => $request->recipient,
            'title' => $request->title,
            'subtitle' => $request->subtitle,
            'text' => $request->text,
            'date' => $request->date,
            'status' => $request->status,
        ]);

        broadcast(new Notifi($notification))->toOthers();

        return response()->json($notification);
    }

    public function deleteNotification(Request $request)
    {
        foreach ($request->ids as $ids):
          Notification::where('id', $ids)->delete();
        endforeach;
        return response()->json("successfully deleted notification");
    }

    public function addToRelevant(Request $request)
    {
        foreach ($request->ids as $ids):
          Notification::where('id', $ids)->update(['status' => 'relevant']);
        endforeach;
        return response()->json("successfully move notification to relevant");
    }

    public function markAsRead()
    {
        Notification::where('status', 'new')->update(['status' => 'all']);
        //"successfully deleted notification"
        return response()->json("successfully updated notifications status");
    }
}
