<?php

namespace App\Http\Controllers;

use App\Models\invoice_attachments;
use Illuminate\Http\Request;
use Auth;

class InvoiceAttachmentsController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:اضافة مرفق', ['only' => ['store']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        abort(404);
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
        // dd($request->all());
        $request->validate([
            'invoice_number' => 'required|max:255',
            'invoice_id' => 'required|integer',
            'file_name' => 'required|mimes:jpeg,pdf,png,jpg',
        ]);
            $file = $request->file('file_name');
            $file_name = time() . $file->getClientOriginalName();
            $invoice_numper= $request->invoice_number;

            $attachments= new invoice_attachments();
            $attachments->filename = $file_name;
            $attachments->invoice_numper = $invoice_numper;
            $attachments->created_by = Auth::user()->name;
            $attachments->invoice_id = $request->invoice_id;
            $attachments->save();

            $fileName = time() . $request->file_name->getClientOriginalName();
            $request->file_name->move(public_path('Attachments/' . $invoice_numper), $fileName);

            return back()->with('success', 'تم إضافة المرفق بنجاح');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\invoice_attachments  $invoice_attachments
     * @return \Illuminate\Http\Response
     */
    public function show(invoice_attachments $invoice_attachments)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\invoice_attachments  $invoice_attachments
     * @return \Illuminate\Http\Response
     */
    public function edit(invoice_attachments $invoice_attachments)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\invoice_attachments  $invoice_attachments
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, invoice_attachments $invoice_attachments)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\invoice_attachments  $invoice_attachments
     * @return \Illuminate\Http\Response
     */
    public function destroy(invoice_attachments $invoice_attachments)
    {
        //
    }
}
