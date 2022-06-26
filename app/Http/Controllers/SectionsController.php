<?php

namespace App\Http\Controllers;

use App\Models\sections;
use Illuminate\Http\Request;
use Auth;

class SectionsController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:الاقسام', ['only' => ['index']]);
        $this->middleware('permission:اضافة قسم', ['only' => ['create','store']]);
        $this->middleware('permission:تعديل قسم', ['only' => ['edit','update']]);
        $this->middleware('permission:حذف قسم', ['only' => ['destroy']]);

    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $section = sections::all();

        return view('sections.sections',compact('section'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //


        $request->validate([
            'section' => 'required|max:255|unique:sections,section_name',
        ]);
        // dd($request->all());

        $section = sections::create([
            'section_name' =>$request->section,
            'description'=>$request->description,
            'created_by' =>Auth::user()->name,
        ]);

        return redirect()->back()->with('section','تمت اضافة القسم بنجاح');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\sections  $sections
     * @return \Illuminate\Http\Response
     */
    public function show(sections $sections)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\sections  $sections
     * @return \Illuminate\Http\Response
     */
    public function edit($section)
    {
        //
        $sections = sections::find($section);
        return view('sections.edit',compact('sections'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\sections  $sections
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$section)
    {
        //
        // dd($section);
        $request->validate([
            'section' => "required|max:255|unique:sections,section_name,$section",
        ]);
        $sections = sections::find($section);
        $sections->section_name = $request->section;
        $sections->description = $request->description;
        $sections->created_by = Auth::user()->name;
        $sections->save();

        return redirect('/sections');


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\sections  $sections
     * @return \Illuminate\Http\Response
     */
    public function destroy($section)
    {
        //
        // dd($section);

        $sections = sections::find($section);
        $sections->delete();

        return redirect()->back()->with('section','تمت حذف القسم بنجاح');


    }
}
