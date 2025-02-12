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

        if (Auth::user()->role == "sale" ||  Auth::user()->role == "admin") {
            $data = DB::table('sales_projects')
                ->where(function ($query) {
                    $query->where('status', '!=', 'completed')
                        ->orWhereNull('responsible_admin')
                        ->orWhereNull('responsible_pm')
                        ->orWhereNull('responsible_contractor');
                })
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
                )
                ->orderBy('sales_projects.created_at', 'DESC') // เรียงลำดับตามวันที่สร้าง
                ->get();
        }

        if (Auth::user()->role == "pm") {
            $data = DB::table('sales_projects')
                ->where(function ($query) {
                    $query->where('responsible_pm', Auth::user()->id);
                })
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
                )
                ->orderBy('sales_projects.created_at', 'DESC') // เรียงลำดับตามวันที่สร้าง
                ->get();
        }

        if (Auth::user()->role == "contractor") {
            $data = DB::table('sales_projects')
                ->where(function ($query) {
                    $query->where('responsible_contractor', Auth::user()->id);
                })
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
                )
                ->orderBy('sales_projects.created_at', 'DESC') // เรียงลำดับตามวันที่สร้าง
                ->get();
        }



        return view('home', compact('data'));
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