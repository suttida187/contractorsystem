<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Models\NotificationsAdmin;
use App\Events\UpdateNotification;

class NotificationController extends Controller
{
    //
    public function fetch()
    {

        if (Auth::user()->role == 'admin') {
            $notifications = DB::table('notifications_admins')
                ->whereNull('read_at')
                ->latest()
                ->get()
                ->map(function ($notification) {
                    return [
                        'id' => $notification->id,
                        'message' => json_decode($notification->data, true)['message'],
                        'time' => Carbon::parse($notification->created_at)->diffForHumans(),
                        'url' => route('notifications.markAsRead', $notification->id),
                    ];
                });
        }
        if (Auth::user()->role == 'sale') {
            $notifications = DB::table('notifications_sales')
                ->whereNull('read_at')
                ->latest()
                ->get()
                ->map(function ($notification) {
                    return [
                        'id' => $notification->id,
                        'message' => json_decode($notification->data, true)['message'],
                        'time' => Carbon::parse($notification->created_at)->diffForHumans(),
                        'url' => route('notifications.markAsRead', $notification->id),
                    ];
                });
        }
        if (Auth::user()->role == 'pm') {
            $notifications = DB::table('notifications_pms')
                ->whereNull('read_at')
                ->latest()
                ->get()
                ->map(function ($notification) {
                    return [
                        'id' => $notification->id,
                        'message' => json_decode($notification->data, true)['message'],
                        'time' => Carbon::parse($notification->created_at)->diffForHumans(),
                        'url' => route('notifications.markAsRead', $notification->id),
                    ];
                });
        }

        if (Auth::user()->role == 'contractor') {
            $notifications = DB::table('notifications_contractors')
                ->whereNull('read_at')
                ->latest()
                ->get()
                ->map(function ($notification) {
                    return [
                        'id' => $notification->id,
                        'message' => json_decode($notification->data, true)['message'],
                        'time' => Carbon::parse($notification->created_at)->diffForHumans(),
                        'url' => route('notifications.markAsRead', $notification->id),
                    ];
                });
        }

        return response()->json($notifications);
    }



    public function AdminNotifications($id, $data, $role)
    {
        if ($role == 'sale') {
            NotificationsAdmin::create([
                'notifiable_id' => $id,
                'data' => $data,
            ]);
        }
        if ($role == 'admin') {
            NotificationsAdmin::create([
                'notifiable_id' => $id,
                'data' => $data,
            ]);
        }

        if ($role == 'pm') {
            NotificationsAdmin::create([
                'notifiable_id' => $id,
                'data' => $data,
            ]);
        }
        if ($role == 'contractor') {
            NotificationsAdmin::create([
                'notifiable_id' => $id,
                'data' => $data,
            ]);
        }


        $notifications = "notifications success";
        event(new UpdateNotification($notifications));
    }
}
