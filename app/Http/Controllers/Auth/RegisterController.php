<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {

        dd($data);
        /*  return Validator::make($data, [
            'role' => 'required|in:admin,sale,pm', // ตรวจสอบค่าที่ส่งจากฟอร์ม
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
            'tax_id' => 'required|digits:13|numeric|unique:users_contractor,tax_id',
        ]); */
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {


        return User::create([
            'role' => $data['role'],
            'username' => $data['username'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'password_confirmation' => Hash::make($data['password_confirmation']),
            'prefix' => $data['prefix'],
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'company_name' => $data['company_name'],
            'address' => $data['address'],
            'street' => $data['street'],
            'sub_district' => $data['sub_district'],
            'district' => $data['district'],
            'province' => $data['province'],
            'phone' => $data['phone'],
            'postal_code' => $data['postal_code'],
            'tax_id' => $data['tax_id'],
        ]);
    }
}