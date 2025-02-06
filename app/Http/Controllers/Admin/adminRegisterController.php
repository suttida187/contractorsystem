<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;

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
        $user =  User::find($id);

        if ($user->role == 'contractor') {
            $status_name = 1;
        } else {
            $status_name = 0;
        }

        return view('admin.register.edit', compact('user', 'status_name'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {

        $user = User::findOrFail($id); // ถ้าไม่พบ User ให้แจ้ง Error 404

        $validatedData = $request->validate([
            'role' => 'required|in:admin,sale,pm,contractor',
            'email' => [
                'required',
                'email',
                Rule::unique('users', 'email')->ignore($user->id), // อนุญาตให้ Email ซ้ำเดิมได้
            ],
            'username' => [
                'required',
                Rule::unique('users', 'username')->ignore($user->id), // อนุญาตให้ Username ซ้ำเดิมได้
            ],
            'password' => 'nullable|confirmed|min:8', // ไม่บังคับ ถ้าใส่ต้องตรงกับ password_confirmation
            'password_confirmation' => 'nullable|same:password', // ไม่บังคับ ถ้าใส่ต้องตรงกับ password
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
            'tax_id' => [
                'nullable',
                'digits:13',
                'numeric',
                Rule::unique('users_contractor', 'tax_id')->ignore($user->id), // อนุญาตให้ Tax ID ซ้ำเดิมได้
            ],
        ]);

        // ถ้ามีการเปลี่ยนรหัสผ่านให้ทำการ Hash แล้วอัปเดต
        if ($request->filled('password')) {
            $validatedData['password'] = Hash::make($request->password);
        } else {
            unset($validatedData['password']); // ถ้าไม่กรอกรหัสผ่าน ให้ใช้ Password เดิม
        }

        // อัปเดตข้อมูล User
        $user->update($validatedData);

        return redirect($user->role == 'contractor' ? 'list-contractor' : 'list-sale-pm-admin')
            ->with('message', "แก้ไขข้อมูลเรียบร้อยแล้ว");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {

        $flight =  User::find($id);
        $flight->delete();
        return redirect()->back()->with('message', 'ลบข้อมูลเรียบร้อยแล้ว');
    }
}