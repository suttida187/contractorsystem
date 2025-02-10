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
        $data = DB::table('sales_projects')
            ->where(function ($query) {
                $query->whereNull('status')
                    ->orWhereNull('responsible_admin')
                    ->orWhereNull('responsible_pm')
                    ->orWhereNull('responsible_contractor');
            })
            ->get();


    


        return view('home', compact('data'));
    }
}