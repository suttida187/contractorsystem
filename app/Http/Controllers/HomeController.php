<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\SalesProjects;
use Carbon\Carbon; // ใช้ Carbon เพื่อความสะดวก
use App\Models\Calendar;
use App\Models\ImageDeliverWork;
use App\Models\User;
use PDF;

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

    public function dataHome()
    {

        $query = DB::table('sales_projects')
            ->leftJoin('users as sale', 'sales_projects.responsible_sale', '=', 'sale.id') // ✅ ต้องเพิ่ม Join นี้
            ->leftJoin('users as admin', 'sales_projects.responsible_admin', '=', 'admin.id')
            ->leftJoin('users as pm', 'sales_projects.responsible_pm', '=', 'pm.id')
            ->leftJoin('users as contractor', 'sales_projects.responsible_contractor', '=', 'contractor.id')
            ->leftJoin('image_deliver_works', 'sales_projects.id', '=', 'image_deliver_works.id_project')
            ->select(
                'sales_projects.*',
                'sale.prefix as sale_prefix',
                'sale.first_name as sale_first_name',
                'sale.last_name as sale_last_name',
                'sale.phone as sale_phone',
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
                'contractor.phone as contractor_phone',
                DB::raw('GROUP_CONCAT(image_deliver_works.image SEPARATOR ", ") as images'), // ✅ ใช้ GROUP_CONCAT
                DB::raw('GROUP_CONCAT(image_deliver_works.message_admin SEPARATOR ", ") as message_admin'),
                DB::raw('GROUP_CONCAT(image_deliver_works.message_pm SEPARATOR ", ") as message_pm'),
                DB::raw('GROUP_CONCAT(image_deliver_works.id SEPARATOR ", ") as deliverWorkId'),
                DB::raw('MAX(image_deliver_works.status) as statusImage') // ✅ ถ้าต้องการสถานะเดียวใช้ MAX
            )
            ->groupBy('sales_projects.id')
            ->distinct(); // ✅ ใช้ DISTINCT เพื่อลดข้อมูลซ้ำ;

        return $query;
    }



    public function index()
    {
        $userRole = Auth::user()->role;
        $userId = Auth::user()->id;

        // สร้าง Query หลัก

        $query = $this->dataHome();


        // เงื่อนไข Role ของผู้ใช้
        switch ($userRole) {
            case "sale":
                $query->where(function ($q) {
                    $q->where('sales_projects.status', '!=', 'completed')->orWhereNull('sales_projects.status');
                });
                break;

            case "admin":

                $query->where('responsible_admin', $userId)
                    ->where(function ($q) {
                        $q->where('sales_projects.status', '!=', 'completed')
                            ->orWhereNull('sales_projects.status');
                    });

                break;

            case "pm":
                $query->where('responsible_pm', $userId)->where(function ($q) {
                    $q->where('sales_projects.status', '!=', 'completed')
                        ->orWhereNull('sales_projects.status');
                });;
                break;

            case "contractor":
                $query->where('responsible_contractor', $userId)->where(function ($q) {
                    $q->where('sales_projects.status', '!=', 'completed')
                        ->orWhereNull('sales_projects.status');
                });;
                break;
        }

        // ดึงข้อมูลเรียงตามวันที่สร้าง
        $data = $query->orderBy('sales_projects.updated_at', 'DESC')->get();



        return view('home', compact('data'));
    }
    public function indexAll()
    {


        $userRole = Auth::user()->role;
        $userId = Auth::user()->id;

        // สร้าง Query หลัก
        $query = $this->dataHome();

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
        $data = $query->orderBy('sales_projects.updated_at', 'DESC')->paginate(100);



        $searchQuery = null; // ค่าจากช่องค้นหา
        $filterStatus = 'projectAll';

        return view('home_all', compact('data', 'searchQuery', 'filterStatus'));
    }
    public function search(Request $request)
    {

        $searchQuery = $request->input('search_query', null);
        $filterStatus = $request->input('filter_status', 'projectAll');

        // เริ่มสร้าง Query หลัก
        $query = $this->dataHome();

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
        $data = $query->orderBy('sales_projects.updated_at', 'DESC')->paginate(100);

        return view('home_all', compact('data', 'searchQuery', 'filterStatus'));
    }
    public function assignWork()
    {


        $userRole = Auth::user()->role;
        $userId = Auth::user()->id;

        // สร้าง Query หลัก
        $query = $this->dataHome();

        // กรองข้อมูลตาม role ของผู้ใช้
        switch ($userRole) {

            case "admin":
                $query->where(function ($q) {
                    $q->where('sales_projects.status', '!=', 'completed')
                        ->orWhereNull('sales_projects.status');
                });

                break;

            case "pm":
                $query->where(function ($q) {
                    $q->where('sales_projects.status', '!=', 'completed')
                        ->orWhereNull('sales_projects.status');
                })
                    ->where('responsible_pm', $userId);

                break;

            case "contractor":
                $query->where(function ($q) {
                    $q->where('sales_projects.status', '!=', 'completed')
                        ->orWhereNull('sales_projects.status');
                })
                    ->where('responsible_contractor', $userId);
                break;
        }

        // ดึงข้อมูลเรียงตามวันที่สร้าง และแบ่งหน้า
        $data = $query->orderBy('sales_projects.updated_at', 'DESC')->paginate(100);

        return view('assign_work', compact('data'));
    }

    public function calendarUser($id)
    {

        // ดึงข้อมูลจาก sales_projects
        $salesProject = DB::table('sales_projects')->where('id', $id)->first();
        $role = Auth::check() && Auth::user()->role === 'admin' ? 'pm' : 'contractor';

        if ($salesProject) {
            $meetingDate = $salesProject->meeting_date;
            $endDate = $salesProject->end_date;

            // ค้นหา user_id ที่มี start_date และ end_date ใน calendars
            $userIdsInCalendars = DB::table('calendars')
                ->where('role',  $role)
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

                ->where('role',   $role)
                ->whereNotIn('id', $userIdsInCalendars)
                ->get();

            return response()->json($usersNotInCalendar);
        }
    }


    public function createCalendar($idUser, $projectId)
    {

        $role = Auth::check() && Auth::user()->role === 'admin' ? 'pm' : 'contractor';

        if (Auth::user()->role === 'admin') {
            SalesProjects::where('id', $projectId)
                ->update(['responsible_admin' => Auth::user()->id, 'responsible_pm' => $idUser]);
        } else {
            SalesProjects::where('id', $projectId)
                ->update(['responsible_contractor' => $idUser]);
        }



        $project = SalesProjects::where('id', $projectId)->first();

        Calendar::create([
            'user_id' => $idUser,
            'role' => $role,
            'projectId' => $projectId,
            'start_date' => $project->meeting_date,
            'end_date' => $project->end_date,
        ]);


        // Admin
        $id = $idUser;
        $role = $role; // ส่งเเจ้งเตือนให้กับ Admin
        $projectName = "มี: $project->project_name มาใหม่";
        $updatedAt = Carbon::now()->toDateTimeString(); // เวลาปัจจุบันในรูปแบบ YYYY-MM-DD HH:MM:SS

        // JSON Encode ให้ถูกต้อง
        $data = json_encode([
            'id_project' =>  $projectId,
            'message' => $projectName,
            'time' => $updatedAt,
            'status' => 'status',
        ], JSON_UNESCAPED_UNICODE); // ป้องกันการแปลงอักขระภาษาไทยเป็น Unicode

        app(NotificationController::class)->CreateNotifications($id, $data, $role);



        return response()->json("หมอบหมายให้ $role  เรียบร้อย");
    }


    public function schedule()
    {

        return view('schedule');
    }

    public function getSchedule($name)
    {

        $events = DB::table('calendars')
            ->leftJoin('sales_projects', 'calendars.projectId', 'sales_projects.id')
            ->where('user_id', $name)
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


        $query = $this->dataHome()
            ->where('sales_projects.id', $id)
            ->first();


        return response()->json($query);
    }


    public function createCalendars(Request $request)
    {
        if ($request->idCalendars == null) {
            Calendar::create([
                'user_id' => Auth::user()->id,
                'role' => Auth::user()->role,
                'start_date' => $request->date,
                'end_date' => $request->date,
                'message' => $request->message,
            ]);

            return redirect('schedule')->with('message', "ลง Calendar เรียบร้อย");
        } else {

            $flight =  Calendar::find($request->idCalendars);
            $flight->delete();
            return redirect('schedule')->with('message', "ลบ Calendar เรียบร้อย");
        }
    }
    public function uploadImage(Request $request)
    {
        $indexes = $request->input('indexes');  // ลำดับที่
        $details = $request->input('details');  // รายละเอียด
        $idProject = $request->input('idProjectImage');  // รายละเอียด
        $images = $request->file('images');     // ไฟล์ภาพที่อัปโหลด (เป็น array ตาม index)

        $data = [];

        if (!empty($indexes) && !empty($details)) {
            foreach ($indexes as $key => $index) {
                $detailText = $details[$key] ?? '';

                // ตรวจสอบว่ามีรูปภาพที่เกี่ยวข้องกับ index หรือไม่
                $uploadedImages = [];
                if (!empty($images) && isset($images[$index])) {

                    foreach ($images[$index] as $image) {
                        if ($image->isValid()) {
                            // ตั้งชื่อไฟล์ใหม่และบันทึก
                            $fileName = time() . '-' . $image->getClientOriginalName();
                            $image->move(public_path('storage/uploads/'), $fileName);
                            // เก็บชื่อไฟล์
                            $uploadedImages[] = $fileName;
                        }
                    }
                }

                // จัดกลุ่มข้อมูลให้แต่ละ index มีรายละเอียดและไฟล์ภาพของตัวเอง
                $data[] = [
                    'index' => $index,
                    'details' => $detailText,
                    'images' => $uploadedImages,
                    'statusImage' => "deliver_work"
                ];
            }
        }


        // บันทึกข้อมูลลงฐานข้อมูล
        ImageDeliverWork::create([
            'id_project' => $idProject,
            'image' => json_encode($data, JSON_UNESCAPED_UNICODE), // ✅ ใช้ json_encode() แทน json_decode()
            'start_date' => $request->date ?? now(), // ถ้าไม่มีข้อมูลให้ใช้วันที่ปัจจุบัน
            'end_date' => $request->date ?? now(), // ถ้าไม่มีข้อมูลให้ใช้วันที่ปัจจุบัน
            'message' => $request->message ?? '', // ป้องกันค่าที่เป็น null
            'status' => "success",
        ]);


        $project = SalesProjects::where('id', $idProject)->first();
        // Admin
        $id = $project->responsible_pm;
        $idSale = $project->responsible_sale;
        $role = "pm"; // ส่งเเจ้งเตือนให้กับ Admin
        $roleSale = "sale"; // ส่งเเจ้งเตือนให้กับ Admin
        $projectName = "contractor  ส่งงาน: $project->project_name เเล้ว";
        $updatedAt = Carbon::now()->toDateTimeString(); // เวลาปัจจุบันในรูปแบบ YYYY-MM-DD HH:MM:SS

        SalesProjects::where('id', $idProject)
            ->update(['status' => 'waiting_pm_review']);
        // JSON Encode ให้ถูกต้อง
        $data = json_encode([
            'id_project' =>  $idProject,
            'message' => $projectName,
            'time' => $updatedAt,
            'status' => 'deliver_work',
        ], JSON_UNESCAPED_UNICODE); // ป้องกันการแปลงอักขระภาษาไทยเป็น Unicode

        app(NotificationController::class)->CreateNotifications($id, $data, $role);
        app(NotificationController::class)->CreateNotifications($idSale, $data, $roleSale);




        return redirect('home')->with('message', "ส่งงานเรียบร้อย");
    }
    public function editUploadImage(Request $request)
    {

        $eventsData = DB::table('image_deliver_works')->where('id', $request->input('id'))->first();

        if (!$eventsData) {
            return response()->json(['error' => 'Data not found'], 404);
        }

        // แปลง image JSON string ให้เป็น array
        $existingImages = json_decode($eventsData->image, true) ?? [];

        // ข้อมูลใหม่จากฟอร์ม
        $newIndexes = $request->input('indexes', []); // ตัวอย่าง: [1, 2]
        $newDetails = $request->input('details', []); // ตัวอย่าง: ["รายละเอียด 1", "รายละเอียด 2"]
        $newImages = $request->file('images', []);   // ไฟล์ที่อัปโหลด (อาจเป็น null ถ้าไม่มี)

        $sanitizedIndexes = array_map(function ($value) {
            return is_array($value) ? reset($value) : $value; // ✅ Ensure only integers/strings
        }, $newIndexes);

        $indexMapping = array_flip($sanitizedIndexes);


        // **วนลูปอัปเดตข้อมูลเดิม**
        foreach ($existingImages as &$item) {


            if (isset($indexMapping[$item['index']])) {
                $indexKey = $indexMapping[$item['index']];

                // ✅ อัปเดตรายละเอียด
                $item['details'] = $newDetails[$indexKey] ?? '';

                // ✅ ลบภาพเก่าถ้ามี
                // 🛠 Debug Old Images Before Deletion


                if (!empty($item['images']) && isset($newImages[$item['index']])) { // ✅ Corrected Condition
                    foreach ($item['images'] as $oldImage) {
                        $imagePath = public_path('storage/uploads/' . $oldImage);
                        if (file_exists($imagePath)) {
                            unlink($imagePath);
                        }
                    }
                }



                // ✅ เพิ่มภาพใหม่
                $uploadedPaths = [];


                if (!empty($newImages) && isset($newImages[$item['index']])) { // ✅ Corrected condition

                    foreach ($newImages[$item['index']] as $image) {
                        if ($image->isValid()) {
                            $fileName = time() . '-' . $image->getClientOriginalName();
                            $image->move(public_path('storage/uploads/'), $fileName);
                            $uploadedPaths[] = $fileName;
                        }
                    }
                }

                // ✅ ตรวจสอบว่าอัปโหลดสำเร็จ
                if (!empty($uploadedPaths)) {
                    $item['images'] = $uploadedPaths;
                }
            }
        }


        // **อัปเดตฐานข้อมูล**
        DB::table('image_deliver_works')
            ->where('id', $request->input('id'))
            ->update([
                'image' => json_encode($existingImages),
                'status' => "deliver_work_update",
                'updated_at' => now()
            ]);


        $idProject =  $eventsData->id_project;


        $project = SalesProjects::where('id', $idProject)->first();
        // Admin
        $id = $project->responsible_pm;
        $idSale = $project->responsible_sale;
        $role = "pm"; // ส่งเเจ้งเตือนให้กับ Admin
        $roleSale = "sale"; // ส่งเเจ้งเตือนให้กับ Admin
        $projectName = "contractor  ส่งงาน : $project->project_name ที่เเก้ไขเเล้ว";
        $updatedAt = Carbon::now()->toDateTimeString(); // เวลาปัจจุบันในรูปแบบ YYYY-MM-DD HH:MM:SS

        SalesProjects::where('id', $idProject)
            ->update(['status' => 'waiting_pm_review']);
        // JSON Encode ให้ถูกต้อง
        $data = json_encode([
            'id_project' =>  $idProject,
            'message' => $projectName,
            'time' => $updatedAt,
            'status' => 'deliver_work',
        ], JSON_UNESCAPED_UNICODE); // ป้องกันการแปลงอักขระภาษาไทยเป็น Unicode

        $result1 = app(NotificationController::class)->CreateNotifications($id, $data, $role);
        $result2 = app(NotificationController::class)->CreateNotifications($idSale, $data, $roleSale);

        if ($result1 === false || $result2 === false) {
            return redirect('home')->with('error', "เกิดข้อผิดพลาดในการส่ง Notification");
        }

        return redirect('home')->with('message', "ส่งงานที่เเก้ไขเรียบร้อย");
    }

    public function checkWork()
    {
        $userRole = Auth::user()->role;
        $userId = Auth::user()->id;

        // สร้าง Query หลัก

        $query = $this->dataHome();


        // เงื่อนไข Role ของผู้ใช้
        switch ($userRole) {
            case "admin":
                $query->where('responsible_admin', $userId)
                    ->where(function ($q) {
                        $q->where('sales_projects.status', '=', 'waiting_admin_review');
                    });
                break;

            case "pm":
                $query->where('responsible_pm', $userId)->where(function ($q) {
                    $q->where('sales_projects.status', '=', 'waiting_pm_review');
                });
        }

        // ดึงข้อมูลเรียงตามวันที่สร้าง
        $data = $query->orderBy('sales_projects.updated_at', 'DESC')->get();



        return view('check_work', compact('data'));
    }


    public function resetWorkImage(Request $request)
    {
        $userRole = Auth::user()->role;
        $userId = Auth::user()->id;




        $idProject =  $request->idProject;


        $project = SalesProjects::where('id', $idProject)->first();



        if ($userRole == "pm") {
            SalesProjects::where('id', $idProject)
                ->update(['status' => 'waiting_contractor']);
            ImageDeliverWork::where('id_project', $idProject)
                ->update(['status' => 'edit_works', 'message_pm' => $request->details]);
        }
        if ($userRole == "admin") {
            SalesProjects::where('id', $idProject)
                ->update(['status' => 'waiting_pm_review']);
            ImageDeliverWork::where('id_project', $idProject)
                ->update(['status' => 'edit_works_pm', 'message_admin' => $request->details]);
        }




        // Admin
        $id =  $userRole == "admin" ? $project->responsible_pm : $project->responsible_contractor;
        $idSale = $project->responsible_sale;
        $role =  $userRole == "pm" ? "contractor" : "pm"; // ส่งเเจ้งเตือนให้กับ Admin
        $roleSale = "sale"; // ส่งเเจ้งเตือนให้กับ Admin
        $projectName =  $userRole == "pm" ? "PM ขอให้ปรับแก้โปรเจกต์ $project->project_name ก่อนดำเนินการต่อ" : "ADMIN ขอให้ปรับแก้โปรเจกต์ $project->project_name ก่อนดำเนินการต่อ";
        $updatedAt = Carbon::now()->toDateTimeString(); // เวลาปัจจุบันในรูปแบบ YYYY-MM-DD HH:MM:SS

        // JSON Encode ให้ถูกต้อง
        $data = json_encode([
            'id_project' =>  $idProject,
            'message' => $projectName,
            'time' => $updatedAt,
            'status' => 'deliver_work',
        ], JSON_UNESCAPED_UNICODE); // ป้องกันการแปลงอักขระภาษาไทยเป็น Unicode

        app(NotificationController::class)->CreateNotifications($id, $data, $role);
        app(NotificationController::class)->CreateNotifications($idSale, $data, $roleSale);


        // dd($request->all());
        // สร้าง Query หลัก


        return redirect('check-work')->with('message', "ส่งานกลับไปให้เเก้ไขเรียบร้อย");
    }
    public function approveWorkImage(Request $request)
    {
        $userRole = Auth::user()->role;
        $userId = Auth::user()->id;




        $idProject =  $request->idProject;


        $project = SalesProjects::where('id', $idProject)->first();



        if ($userRole == "pm") {
            SalesProjects::where('id', $idProject)
                ->update(['status' => 'waiting_admin_review']);
            ImageDeliverWork::where('id_project', $idProject)
                ->update(['status' => 'approve_admin_works']);
        }
        if ($userRole == "admin") {
            SalesProjects::where('id', $idProject)
                ->update(['status' => 'completed']);
            ImageDeliverWork::where('id_project', $idProject)
                ->update(['status' => 'success', 'message_admin' => null, 'message_pm' => null]);
        }




        // Admin
        $id =  $project->responsible_admin;
        $idSale = $project->responsible_sale;
        $role = "admin"; // ส่งเเจ้งเตือนให้กับ Admin
        $roleSale = "sale"; // ส่งเเจ้งเตือนให้กับ Admin
        $projectName =  $userRole == "pm" ? "PM ตรวจสอบ โปรเจกต์ $project->project_name เรียบร้อยเเล้ว" : "ADMIN ตรวจสอบ โปรเจกต์ $project->project_name เรียบร้อยเเล้ว";
        $updatedAt = Carbon::now()->toDateTimeString(); // เวลาปัจจุบันในรูปแบบ YYYY-MM-DD HH:MM:SS

        // JSON Encode ให้ถูกต้อง
        $data = json_encode([
            'id_project' =>  $idProject,
            'message' => $projectName,
            'time' => $updatedAt,
            'status' => 'deliver_work',
        ], JSON_UNESCAPED_UNICODE); // ป้องกันการแปลงอักขระภาษาไทยเป็น Unicode
        $dataSale = json_encode([
            'id_project' =>  $idProject,
            'message' => $projectName,
            'time' => $updatedAt,
            'status' => 'success',
        ], JSON_UNESCAPED_UNICODE); // ป้องกันการแปลงอักขระภาษาไทยเป็น Unicode

        app(NotificationController::class)->CreateNotifications($id, $data, $role);
        app(NotificationController::class)->CreateNotifications($idSale, $dataSale, $roleSale);

        if ($userRole == "admin") {
            DB::table('calendars')
                ->where('projectId', $idProject)
                ->delete();
        }
        // dd($request->all());
        // สร้าง Query หลัก


        return redirect('check-work')->with('message', "ตรวจสอบงานเรียบร้อยเเล้ว");
    }
    public function exportPdf($id)
    {
        $data = $this->dataHome()
            ->where('sales_projects.id', $id)
            ->first();
        /*   return view('admin.exportPdf', compact('data')); */
        $pdf = PDF::loadView('admin.exportPdf', [
            'data' => $data  // ✅ Use an associative array
        ]);

        $pdf->setPaper('a4', 'portrait') // ✅ Corrected A4 Paper Settings
            ->setOption('margin-top', 15)
            ->setOption('margin-bottom', 15)
            ->setOption('margin-left', 10)
            ->setOption('margin-right', 10);

        return $pdf->stream('exportPDF.pdf');
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
//waiting_contractor // ส่งงาน
//waiting_pm_review  //รอ pm ตรวจ
//waiting_admin_review //รอ admin ตรวจ
//completed  //เสร็จ