<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\SalesProjects;
use Carbon\Carbon; // ใช้ Carbon เพื่อความสะดวก
use App\Models\Calendar;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $userRole = Auth::user()->role;
        $userId = Auth::user()->id;

        // สร้าง Query หลัก
        $query = DB::table('sales_projects')
            ->leftJoin('users as admin', 'sales_projects.responsible_admin', '=', 'admin.id')
            ->leftJoin('users as pm', 'sales_projects.responsible_pm', '=', 'pm.id')
            ->leftJoin('users as contractor', 'sales_projects.responsible_contractor', '=', 'contractor.id')
            ->select(
                'sales_projects.*',
                'admin.prefix as admin_prefix',
                'admin.first_name as admin_first_name',
                'admin.last_name as admin_last_name',
                'admin.phone as admin_phone',
                'pm.prefix as pm_prefix',
                'pm.first_name as pm_first_name',
                'pm.last_name as pm_last_name',
                'pm.phone as pm_phone',
                'contractor.prefix as contractor_prefix',
                'contractor.first_name as contractor_first_name',
                'contractor.last_name as contractor_last_name',
                'contractor.phone as contractor_phone'
            );

        // เงื่อนไข Role ของผู้ใช้
        switch ($userRole) {
            case "sale":
                $query->where(function ($q) {
                    $q->where('status', '!=', 'completed')->orWhereNull('status');
                });
                break;

            case "admin":
                $query->where('responsible_admin', $userId)
                    ->where(function ($q) {
                        $q->where('status', '!=', 'completed')
                            ->orWhereNull('status');
                    });

                break;

            case "pm":
                $query->where('responsible_pm', $userId)->where(function ($q) {
                    $q->where('status', '!=', 'completed')
                        ->orWhereNull('status');
                });;
                break;

            case "contractor":
                $query->where('responsible_contractor', $userId)->where(function ($q) {
                    $q->where('status', '!=', 'completed')
                        ->orWhereNull('status');
                });;
                break;
        }

        // ดึงข้อมูลเรียงตามวันที่สร้าง
        $data = $query->orderBy('sales_projects.created_at', 'DESC')->get();



        return view('home', compact('data'));
    }
    public function indexAll()
    {


        $userRole = Auth::user()->role;
        $userId = Auth::user()->id;

        // สร้าง Query หลัก
        $query = DB::table('sales_projects')
            ->leftJoin('users as admin', 'sales_projects.responsible_admin', '=', 'admin.id')
            ->leftJoin('users as pm', 'sales_projects.responsible_pm', '=', 'pm.id')
            ->leftJoin('users as contractor', 'sales_projects.responsible_contractor', '=', 'contractor.id')
            ->select(
                'sales_projects.*',
                'admin.prefix as admin_prefix',
                'admin.first_name as admin_first_name',
                'admin.last_name as admin_last_name',
                'admin.phone as admin_phone',
                'pm.prefix as pm_prefix',
                'pm.first_name as pm_first_name',
                'pm.last_name as pm_last_name',
                'pm.phone as pm_phone',
                'contractor.prefix as contractor_prefix',
                'contractor.first_name as contractor_first_name',
                'contractor.last_name as contractor_last_name',
                'contractor.phone as contractor_phone'
            );

        // กรองข้อมูลตาม role ของผู้ใช้
        switch ($userRole) {
            case "sale":

                break;

            case "admin":
                $query->where('responsible_admin', $userId);
                break;

            case "pm":
                $query->where('responsible_pm', $userId);
                break;

            case "contractor":
                $query->where('responsible_contractor', $userId);
                break;
        }

        // ดึงข้อมูลเรียงตามวันที่สร้าง และแบ่งหน้า
        $data = $query->orderBy('sales_projects.created_at', 'DESC')->paginate(100);



        $searchQuery = null; // ค่าจากช่องค้นหา
        $filterStatus = 'projectAll';

        return view('home_all', compact('data', 'searchQuery', 'filterStatus'));
    }
    public function search(Request $request)
    {

        $searchQuery = $request->input('search_query', null);
        $filterStatus = $request->input('filter_status', 'projectAll');

        // เริ่มสร้าง Query หลัก
        $query = DB::table('sales_projects')
            ->leftJoin('users as admin', 'sales_projects.responsible_admin', '=', 'admin.id')
            ->leftJoin('users as pm', 'sales_projects.responsible_pm', '=', 'pm.id')
            ->leftJoin('users as contractor', 'sales_projects.responsible_contractor', '=', 'contractor.id')
            ->select(
                'sales_projects.*',
                'admin.prefix as admin_prefix',
                'admin.first_name as admin_first_name',
                'admin.last_name as admin_last_name',
                'admin.phone as admin_phone',
                'pm.prefix as pm_prefix',
                'pm.first_name as pm_first_name',
                'pm.last_name as pm_last_name',
                'pm.phone as pm_phone',
                'contractor.prefix as contractor_prefix',
                'contractor.first_name as contractor_first_name',
                'contractor.last_name as contractor_last_name',
                'contractor.phone as contractor_phone'
            );

        // เงื่อนไขค้นหาชื่อโครงการ (ถ้ามีค่า)
        $query->when(!empty($searchQuery), function ($query) use ($searchQuery) {
            $query->where('sales_projects.project_name', 'LIKE', "%$searchQuery%");
        });

        // เงื่อนไขตัวกรองสถานะ (แสดงทั้งหมดถ้า `$filterStatus == 'projectAll'`)
        if ($filterStatus !== 'projectAll') {
            $query->where('sales_projects.status', $filterStatus);
        }

        // เงื่อนไข Role ของผู้ใช้
        switch (Auth::user()->role) {
            case "admin":
                $query->where('responsible_admin', Auth::user()->id);
                break;

            case "pm":
                $query->where('responsible_pm', Auth::user()->id);
                break;

            case "contractor":
                $query->where('responsible_contractor', Auth::user()->id);
                break;

            case "sale":
                // ไม่มีเงื่อนไขเพิ่มเติม (แสดงทั้งหมด)

                break;
        }

        // ดึงข้อมูลเรียงตามวันที่สร้าง และแบ่งหน้า
        $data = $query->orderBy('sales_projects.created_at', 'DESC')->paginate(100);

        return view('home_all', compact('data', 'searchQuery', 'filterStatus'));
    }
    public function assignWork()
    {


        $userRole = Auth::user()->role;
        $userId = Auth::user()->id;

        // สร้าง Query หลัก
        $query = DB::table('sales_projects')
            ->leftJoin('users as admin', 'sales_projects.responsible_admin', '=', 'admin.id')
            ->leftJoin('users as pm', 'sales_projects.responsible_pm', '=', 'pm.id')
            ->leftJoin('users as contractor', 'sales_projects.responsible_contractor', '=', 'contractor.id')
            ->select(
                'sales_projects.*',
                'admin.prefix as admin_prefix',
                'admin.first_name as admin_first_name',
                'admin.last_name as admin_last_name',
                'admin.phone as admin_phone',
                'pm.prefix as pm_prefix',
                'pm.first_name as pm_first_name',
                'pm.last_name as pm_last_name',
                'pm.phone as pm_phone',
                'contractor.prefix as contractor_prefix',
                'contractor.first_name as contractor_first_name',
                'contractor.last_name as contractor_last_name',
                'contractor.phone as contractor_phone'
            );

        // กรองข้อมูลตาม role ของผู้ใช้
        switch ($userRole) {

            case "admin":
                $query->where(function ($q) {
                    $q->where('status', '!=', 'completed')
                        ->orWhereNull('status');
                });

                break;

            case "pm":
                $query->where(function ($q) {
                    $q->where('status', '!=', 'completed')
                        ->orWhereNull('status');
                })
                    ->where('responsible_pm', $userId);

                break;

            case "contractor":
                $query->where(function ($q) {
                    $q->where('status', '!=', 'completed')
                        ->orWhereNull('status');
                })
                    ->where('responsible_contractor', $userId);
                break;
        }

        // ดึงข้อมูลเรียงตามวันที่สร้าง และแบ่งหน้า
        $data = $query->orderBy('sales_projects.created_at', 'DESC')->paginate(100);

        return view('assign_work', compact('data'));
    }

    public function calendarUser($id)
    {

        // ดึงข้อมูลจาก sales_projects
        $salesProject = DB::table('sales_projects')->where('id', $id)->first();

        if ($salesProject) {
            $meetingDate = $salesProject->meeting_date;
            $endDate = $salesProject->end_date;

            // ค้นหา user_id ที่มี start_date และ end_date ใน calendars
            $userIdsInCalendars = DB::table('calendars')
                ->where('role', 'pm')
                ->where(function ($query) use ($meetingDate, $endDate) {
                    $query->where(function ($subQuery) use ($meetingDate, $endDate) {
                        $subQuery->where('start_date', '<=', $endDate)
                            ->where('end_date', '>=', $meetingDate);
                    });
                })
                ->pluck('user_id')
                ->toArray(); // เอาเฉพาะ user_id เป็น array

            // ดึง users ที่ไม่มี user_id อยู่ใน calendars
            $usersNotInCalendar = DB::table('users')
                ->where('role', 'pm')
                ->whereNotIn('id', $userIdsInCalendars)
                ->get();

            return response()->json($usersNotInCalendar);
        }
    }


    public function createCalendarPm($idUser, $projectId)
    {
        SalesProjects::where('id', $projectId)
            ->update(['responsible_admin' => Auth::user()->id, 'responsible_pm' => $idUser]);

        $project = SalesProjects::where('id', $projectId)->first();

        Calendar::create([
            'user_id' => $idUser,
            'role' => 'pm',
            'projectId' => 'projectId',
            'start_date' => $project->meeting_date,
            'end_date' => $project->end_date,
        ]);


        // Admin
        $id = $idUser;
        $role = "pm"; // ส่งเเจ้งเตือนให้กับ Admin
        $projectName = "มี: $project->project_name มาใหม่";
        $updatedAt = Carbon::now()->toDateTimeString(); // เวลาปัจจุบันในรูปแบบ YYYY-MM-DD HH:MM:SS

        // JSON Encode ให้ถูกต้อง
        $data = json_encode([
            'id_project' =>  $projectId,
            'message' => $projectName,
            'time' => $updatedAt
        ], JSON_UNESCAPED_UNICODE); // ป้องกันการแปลงอักขระภาษาไทยเป็น Unicode

        app(NotificationController::class)->CreateNotifications($id, $data, $role);



        return response()->json("หมอบหมายให้ PM  เรียบร้อย");
    }


    public function schedule()
    {

        return view('schedule');
    }

    public function getSchedule($name)
    {

        $events = DB::table('calendars')->leftJoin('sales_projects', 'calendars.projectId', 'sales_projects.id')->where('user_id', $name)
            ->select(
                'calendars.*',
                'sales_projects.id  as projectId',
                'sales_projects.project_name',
            )
            ->get();

        return response()->json($events);
    }
    public function userEndpoint($name)
    {


        $events = DB::table('users')->where('role', $name)->get();
        return response()->json($events);
    }
    public function getProject($id)
    {


        $query = DB::table('sales_projects')
            ->where('sales_projects.id', $id)
            ->leftJoin('users as admin', 'sales_projects.responsible_admin', '=', 'admin.id')
            ->leftJoin('users as pm', 'sales_projects.responsible_pm', '=', 'pm.id')
            ->leftJoin('users as contractor', 'sales_projects.responsible_contractor', '=', 'contractor.id')
            ->select(
                'sales_projects.*',
                'admin.prefix as admin_prefix',
                'admin.first_name as admin_first_name',
                'admin.last_name as admin_last_name',
                'admin.phone as admin_phone',
                'pm.prefix as pm_prefix',
                'pm.first_name as pm_first_name',
                'pm.last_name as pm_last_name',
                'pm.phone as pm_phone',
                'contractor.prefix as contractor_prefix',
                'contractor.first_name as contractor_first_name',
                'contractor.last_name as contractor_last_name',
                'contractor.phone as contractor_phone'
            )->first();

        return response()->json($query);
    }
}



//if (status = null)
//responsible_admin && responsible_pm && responsible_contractor  = null  ให้เป็น //รอ admin ดำเนินการ
//responsible_admin != null && responsible_pm  != null && responsible_contractor  = null  ให้เป็น //รอ pm ดำเนินการ
//responsible_admin != null && responsible_pm  != null  && responsible_contractor  != null   = null  ให้เป็น //รอ ผู้รับเหมาดำเนินงาน
//else {  status  != null
//รอ ผู้รับเหมาส่งมอบงาน
//รอ PM ตรวจสอบ
//เสร็จสมบูรณ์
//}