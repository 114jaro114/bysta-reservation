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
        // + "successfully deleted notification"
        return response()->json($request->ids);
    }
}
