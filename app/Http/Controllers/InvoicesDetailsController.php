<?php

namespace App\Http\Controllers;

use App\Models\invoices_details;
use App\Models\invoices;
use App\Models\invoice_attachments;
use Storage;

use Illuminate\Http\Request;

class InvoicesDetailsController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:حذف المرفق', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\invoices_details  $invoices_details
     * @return \Illuminate\Http\Response
     */
    public function show(invoices_details $invoices_details)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\invoices_details  $invoices_details
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $invoices = invoices::where('id',$id)->first();
        if($invoices){
            $details = invoices_details::where('invoice_id',$id)->get();

            $attachments = invoice_attachments::where('invoice_id',$id)->get();

            return view('invoices.invoicesdetails',compact('invoices','details','attachments'));

        }else{
            abort(404);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\invoices_details  $invoices_details
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, invoices_details $invoices_details)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\invoices_details  $invoices_details
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        //
        // dd($request->all());
        $file = invoice_attachments::findOrFail($request->id);
        $file->delete();
        Storage::disk('public_uploads')->delete($request->invoice_numper.'/'.$request->file_name);
        return redirect()->back()->with('success','تم حذف الملف بنجاح');
    }
    public function openfile($invoices_numper,$file_name)
    {
        //
        $file = storage::disk('public_uploads')->getDriver()->getAdapter()->applyPathPrefix($invoices_numper . "/" . $file_name);

        return response()->file($file);
    }
    public function download($invoices_numper,$file_name)
    {
        //
        $file = storage::disk('public_uploads')->getDriver()->getAdapter()->applyPathPrefix($invoices_numper . "/" . $file_name);

        return response()->download($file);
    }


}
