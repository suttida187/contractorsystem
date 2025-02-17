<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

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
                $query->where('responsible_admin', $userId)->where('status', '!=', 'completed');
                break;

            case "pm":
                $query->where('responsible_pm', $userId)->where('status', '!=', 'completed');
                break;

            case "contractor":
                $query->where('responsible_contractor', $userId)->where('status', '!=', 'completed');
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
                ->where('role', 'sale')
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
                ->where('role', 'sale')
                ->whereNotIn('id', $userIdsInCalendars)
                ->get();
            return response()->json($usersNotInCalendar);
        }
    }
    public function createCalendar($idUser, $projectId)
    {

        // ดึงข้อมูลจาก sales_projects
        dd($idUser, $projectId);
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