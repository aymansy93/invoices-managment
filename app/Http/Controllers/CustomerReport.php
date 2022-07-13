<?php

namespace App\Http\Controllers;
use App\Models\sections;
use App\Models\invoices;

use Illuminate\Http\Request;

class CustomerReport extends Controller
{
    //
    function __construct()
    {
        $this->middleware('permission:التقارير');
        $this->middleware('permission:تقرير العملاء',['only'=>['index','search_invoices']]);
    }
    public function index(){
        $section = sections::all();
        return view('reborts.customer_report',compact('section'));
    }

    public function search_invoices(Request $request){
        // dd($request->all());

        $request->validate([
            'product' =>  'required|max:255',
            'section' =>  'required|max:255',
        ]);

        $section = sections::all();

            if($request->start_at == '' && $request->end_at == ''){
                if($request->product == "all"){
                    $invoices = invoices::select('*')->where('section_id',$request->section)->get();
                }else{
                    $invoices = invoices::select('*')->where('section_id',$request->section)->where('product',$request->product)->get();
                }
                return view('reborts.customer_report',compact('section'))->withDetails($invoices);

            }else{
                // dd($request->all());
                $start_at = date($request->start_at);
                $end_at = date($request->end_at);
                if($request->product == "all"){
                    $invoices = invoices::whereBetween('invoice_Date',[$start_at,$end_at])->where('section_id',$request->section)->get();
                }else{
                    $invoices = invoices::whereBetween('invoice_Date',[$start_at,$end_at])->where('section_id',$request->section)->where('product',$request->product)->get();
                }
                return view('reborts.customer_report',compact('section','start_at','end_at'))->withDetails($invoices);
            }


    }
}
