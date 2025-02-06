<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class adminRegisterController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $routeActive = request()->path();

        $users = DB::table('users');


        if ($routeActive == 'list-sale-pm-admin') {
            $users = $users->where('role', '!=', 'contractor')->get();
        } else {
            $users = $users->where('role', 'contractor')->get();
        }


        return view('admin.register.index', compact('users', 'routeActive'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        $status_name = 0;
        return view('admin.register.register', compact('status_name'));
    }
    public function createContractor()
    {

        $status_name = 1;
        return view('admin.register.register', compact('status_name'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $validatedData = $request->validate([
            'role' => 'required|in:admin,sale,pm,contractor', // ตรวจสอบค่าที่ส่งจากฟอร์ม
            'email' => 'required|email|unique:users,email',
            'username' => 'required|unique:users,username',
            'password' => 'required|confirmed|min:8',
            'password_confirmation' => 'required_with:password|same:password',
            'prefix' => 'required|string',
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'company_name' => 'required|string',
            'address' => 'required|string',
            'street' => 'required|string',
            'sub_district' => 'required|string',
            'district' => 'required|string',
            'province' => 'required|string',
            'phone' => 'required|numeric|digits:10',
            'postal_code' => 'required|numeric|digits:5',
            'tax_id' => 'nullable|digits:13|numeric|unique:users_contractor,tax_id',
        ]);



        User::create($validatedData);
        return redirect('home')->with('message', "บันทึกสำเร็จ");
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}