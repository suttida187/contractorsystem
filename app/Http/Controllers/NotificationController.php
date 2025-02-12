<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Models\NotificationsAdmin;
use App\Models\NotificationsSale;
use App\Models\NotificationsPm;
use App\Models\NotificationsContractor;
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
                        'id_project' => json_decode($notification->data, true)['id_project'],
                        'message' => json_decode($notification->data, true)['message'],
                        'time' => Carbon::parse($notification->created_at)->diffForHumans(),
                        'url' => route('notifications.markAsRead', [
                            'notificationId' => $notification->id,
                            'projectId' => json_decode($notification->data, true)['id_project']
                        ])

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
                        'id_project' => json_decode($notification->data, true)['id_project'],
                        'message' => json_decode($notification->data, true)['message'],
                        'time' => Carbon::parse($notification->created_at)->diffForHumans(),
                        'url' => route('notifications.markAsRead', [
                            'notificationId' => $notification->id,
                            'projectId' => json_decode($notification->data, true)['id_project']
                        ])
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
                        'id_project' => json_decode($notification->data, true)['id_project'],
                        'message' => json_decode($notification->data, true)['message'],
                        'time' => Carbon::parse($notification->created_at)->diffForHumans(),
                        'url' => route('notifications.markAsRead', [
                            'notificationId' => $notification->id,
                            'projectId' => json_decode($notification->data, true)['id_project']
                        ])
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
                        'id_project' => json_decode($notification->data, true)['id_project'],
                        'message' => json_decode($notification->data, true)['message'],
                        'time' => Carbon::parse($notification->created_at)->diffForHumans(),
                        'url' => route('notifications.markAsRead', [
                            'notificationId' => $notification->id,
                            'projectId' => json_decode($notification->data, true)['id_project']
                        ])
                    ];
                });
        }

        return response()->json($notifications);
    }



    public function CreateNotifications($id, $data, $role)
    {
        if ($role == 'sale') {
            NotificationsSale::create([
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
            NotificationsPm::create([
                'notifiable_id' => $id,
                'data' => $data,
            ]);
        }
        if ($role == 'contractor') {
            NotificationsContractor::create([
                'notifiable_id' => $id,
                'data' => $data,
            ]);
        }


        $notifications = "notifications success";
        event(new UpdateNotification($notifications));
    }


    public function UpdateReadAt(string $id)
    {

        $role = Auth::user()->role;
        if ($role == 'sale') {
            NotificationsSale::where('id', $id)
                ->update(['read_at' => Carbon::now()->format('Y-m-d H:i:s')]);
        }
        if ($role == 'admin') {
            NotificationsAdmin::where('id', $id)
                ->update(['read_at' => Carbon::now()->format('Y-m-d H:i:s')]);
        }

        if ($role == 'pm') {
            NotificationsPm::where('id', $id)
                ->update(['read_at' => Carbon::now()->format('Y-m-d H:i:s')]);
        }
        if ($role == 'contractor') {
            NotificationsContractor::where('id', $id)
                ->update(['read_at' => Carbon::now()->format('Y-m-d H:i:s')]);
        }

        return back();
    }
}