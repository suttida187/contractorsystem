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

        if (Auth::user()->role == 'pm') {
            $notifications = DB::table('notifications_pms')
                ->where('notifiable_id', Auth::user()->id)
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
                ->where('notifiable_id', Auth::user()->id)
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
        try {
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
        } catch (\Exception $e) {
            \Log::error("Error in CreateNotifications: " . $e->getMessage());
            return false;
        }
    }




    public function UpdateReadAt(string $notificationId, string $projectId)
    {

        $role = Auth::user()->role;
        if ($role == 'sale') {
            NotificationsSale::where('id', $notificationId)
                ->update(['read_at' => Carbon::now()->format('Y-m-d H:i:s')]);
        }
        if ($role == 'admin') {


            NotificationsAdmin::where('id', $notificationId)
                ->update(['read_at' => Carbon::now()->format('Y-m-d H:i:s')]);

            $not_data = DB::table('notifications_admins')
                ->where('id', $notificationId)
                ->first();

            if (json_decode($not_data->data)->status  == 'newProject') {
                return redirect('assign-work');
            }
            if (json_decode($not_data->data)->status  == 'deliver_work') {
                return redirect('check-work');
            }
        }

        if ($role == 'pm') {
            NotificationsPm::where('id', $notificationId)
                ->update(['read_at' => Carbon::now()->format('Y-m-d H:i:s')]);

            $not_data = DB::table('notifications_pms')
                ->where('id', $notificationId)
                ->first();

            if (json_decode($not_data->data)->status  == 'deliver_work') {
                return redirect('check-work');
            }
        }
        if ($role == 'contractor') {
            NotificationsContractor::where('id', $notificationId)
                ->update(['read_at' => Carbon::now()->format('Y-m-d H:i:s')]);
        }


        return redirect('home')->with('message', "ส่งงานที่เเก้ไขเรียบร้อย");
    }
}