<?php

namespace App\Http\Controllers\Sale;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\SalesProjects;


class FormSaleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $work_types =   DB::table('work_types')->get();
        $warranty_options =   DB::table('warranty_options')->get();
        $solutions =   DB::table('solutions')->get();
        return view('sale.create', compact('work_types', 'warranty_options', 'solutions'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'project_name' => 'required|string|max:255',
            'work_type' => 'required|string',
            'other_work_type' => 'nullable|required_if:work_type,Other|string|max:255',
            'solution' => 'required|string',
            'other_solution' => 'nullable|required_if:solution,Other|string|max:255',
            'work_description' => 'required|string',
            'meeting_date' => 'required|date',
            'meeting_time' => 'required|date_format:H:i',
            'end_date' => 'required|date',
            'company_name' => 'required|string|max:255',
            'contact_name' => 'required|string|max:255',
            'contact_phone' => 'required|regex:/^[0-9]{9,10}$/',
            'contact_position' => 'required|string|max:255',
            'location' => 'required|url',
            'warranty' => 'required|string',
            'additional_notes' => 'nullable|string',
            'needs_documents' => 'required|string',
        ]);

       
        SalesProjects::create($validatedData);
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