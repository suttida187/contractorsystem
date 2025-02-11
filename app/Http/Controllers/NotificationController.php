<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

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
}
