<?php

namespace App\Http\Controllers;
use App\Models\invoices;
use Illuminate\Http\Request;

class invoicesreports extends Controller
{
    //
    function __construct()
    {
        $this->middleware('permission:التقارير');
        $this->middleware('permission:تقرير الفواتير',['only'=>['index','search_invoices']]);
    }
    public function index(){
        return view('reborts.report');
    }
    public function search_invoices(Request $request){
        // dd($request->all());
        if($request->search == 1){
            $type = $request->type;
            if($request->type && $request->start_at == '' && $request->end_at == ''){
                $invoices = invoices::select('*')->where('status',$type)->get();
                return view('reborts.report',compact('type'))->withDetils($invoices);

            }else{
                $start_at = date($request->start_at);
                $end_at = date($request->end_at);
                $invoices = invoices::whereBetween('invoice_Date',[$start_at,$end_at])->where('status',$type)->get();
                return view('reborts.report',compact('type','start_at','end_at'))->withDetils($invoices);
            }


        }elseif($request->search == 2){
            // dd($request->all());
            $invoices= invoices::select('*')->where('invoice_number',$request->invoice_number)->get();
            return view('reborts.report')->withDetils($invoices);

        }else{
            abort(404);
        }
    }
}
