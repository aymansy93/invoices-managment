<?php

namespace App\Http\Controllers;
use App\Notifications\invoicemail;
use Illuminate\Support\Facades\Notification;
use App\Models\invoices;
use App\Models\invoices_details;
use App\Models\invoice_attachments;
use App\Models\User;
use App\Models\sections;
use App\Models\products;
use Illuminate\Http\Request;
use DB;
use Auth;
use Storage;
class InvoicesController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:قائمة الفواتير', ['only' => ['index']]);
        $this->middleware('permission:paidding', ['only' => ['paidding']]);
        $this->middleware('permission:اضافة فاتورة', ['only' => ['create','store']]);
        $this->middleware('permission:تعديل الفاتورة', ['only' => ['edit','update']]);
        $this->middleware('permission:حذف الفاتورة', ['only' => ['destroy']]);
        $this->middleware('permission:ارشفة الفاتورة', ['only' => ['destroy']]);
        $this->middleware('permission:طباعةالفاتورة', ['only' => ['print']]);
        $this->middleware('permission:تغير حالة الدفع', ['only' => ['status_update','show']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $invoices= invoices::all();

        return view("invoices.invoices",compact('invoices'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //

        $sections = sections::all();
        return view('invoices.add_invoice',compact('sections'));
    }
    public function getproducts($id){
        $products = DB::table('products')->where('section_id',$id)->pluck('products_name','id');
        return json_encode($products);
    }
    public function paidding($id){

        if($id == 1){
            $invoices = invoices::where('value_status',1)->get();
            return view('invoices.paidding',compact('invoices' ,'id'));
        }elseif($id == 2){
            $invoices = invoices::where('value_status',2)->get();
            return view('invoices.paidding',compact('invoices','id'));
        }elseif($id == 3){
            $invoices = invoices::where('value_status',3)->get();
            return view('invoices.paidding',compact('invoices','id'));
        }else{
            abort(404);
        }
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
            'invoice_Date' => 'required|max:255',
            'Due_date' => 'required|max:255',
            'product' =>  'required|max:255',
            'section' =>  'required|max:255',
            'Amount_collection' =>  'required|integer|digits_between:2,7',
            'Amount_Commission' =>  'required|max:255',
            'Discount' =>  'required|max:255',
            'Rate_VAT' =>  'required|max:255',
            'Value_VAT' =>  'required|max:255',
            'Total' => 'required|max:255',
            'pic' => 'mimes:jpeg,pdf,png,jpg',


        ],[
            'Amount_collection.digits_between' => "the number must not exceed 8 characters",
        ]);
        // dd($request->invoice_Date);
        invoices::create([
            'invoice_number' => $request->invoice_number,
            'invoice_Date' => $request->invoice_Date,
            'due_date' => $request->Due_date,
            'product' => $request->product,
            'section_id' => $request->section,
            'Amount_collection' => $request->Amount_collection,
            'Amount_Commission' => $request->Amount_Commission,
            'discount' => $request->Discount,
            'rate_vat' => $request->Rate_VAT,
            'value_vat' => $request->Value_VAT,
            'total' => $request->Total,
            'status' => 'غير مدفوعة',
            'value_status' => '2',
            'note' => $request->note,
            'user' => Auth::user()->name,
            'user_id'=>Auth::user()->id,

        ]);

        $invoice_id = invoices::latest()->first()->id;

        invoices_details::create([
            'invoice_id' => $invoice_id,
            'invoice_numper' => $request->invoice_number,
            'product' => $request->product,
            'section' => $request->section,
            'status' => "غير مدفوعة",
            'value_status' => 2,
            'note' => $request->note,
            'user' => Auth::user()->name,
        ]);

        if($request->hasFile('pic')){

            $invoice_id = invoices::latest()->first()->id;
            $image = $request->file('pic');
            $file_name = $image->getClientOriginalName();
            $invoice_numper= $request->invoice_number;

            $attachments= new invoice_attachments();
            $attachments->filename = $file_name;
            $attachments->invoice_numper = $invoice_numper;
            $attachments->created_by = Auth::user()->name;
            $attachments->invoice_id = $invoice_id;
            $attachments->save();

            $imageName = $request->pic->getClientOriginalName();
            $request->pic->move(public_path('Attachments/' . $invoice_numper), $imageName);


        }

        // send email to user
        // $user = Auth::user();
        $user = User::get();
        Notification::send($user, new invoicemail($invoice_id));

        return redirect()->back()->with('Add','تمت اضافة الفاتورة بنجاح');



    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\invoices  $invoices
     * @return \Illuminate\Http\Response
     */
    public function show($invoice)
    {
        //
        $invoices = invoices::where('id',$invoice)->first();
        if($invoices){
        return view('invoices.show_status',compact('invoices'));
        }else{
            abort(404);
        }
    }
    public function print($id){
        $invoices = invoices::where('id',$id)->first();
        if($invoices){
            return view('invoices.print',compact('invoices'));
        }else{
            abort(404);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\invoices  $invoices
     * @return \Illuminate\Http\Response
     */
    public function edit($invoice)
    {
        //
        $invoice = invoices::find($invoice)->first();
        $sections = sections::all();
        return view('invoices.edit_invoice',compact('invoice','sections'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\invoices  $invoices
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $invoice)
    {
        //
        // dd($request->all());
        $request->validate([
            'invoice_Date' => 'required|max:255',
            'Due_date' => 'required|max:255',
            'product' =>  'required|max:255',
            'section' =>  'required|max:255',
            'Amount_collection' =>  'required|numeric|max:1000000',
            'Amount_Commission' =>  'required|max:255',
            'Discount' =>  'required|max:255',
            'Rate_VAT' =>  'required|max:255',
            'Value_VAT' =>  'required|max:255',
            'Total' => 'required|max:255',
        ]);

        $invoices = invoices::find($invoice);
        $invoices->update([

            'due_date' => $request->Due_date,
            'product' => $request->product,
            'section_id' => $request->section,
            'Amount_collection' => $request->Amount_collection,
            'Amount_Commission' => $request->Amount_Commission,
            'discount' => $request->Discount,
            'rate_vat' => $request->Rate_VAT,
            'value_vat' => $request->Value_VAT,
            'total' => $request->Total,
            'status' => 'غير مدفوعة',
            'value_status' => '2',
            'note' => $request->note,
            'user' => Auth::user()->name,
            'user_id'=>Auth::user()->id,
        ]);

        return redirect()->back()->with('edit','تم تعديل الفاتورة بنجاح');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\invoices  $invoices
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $invoice)
    {
        //
        if($invoice === 'invoice'){
            $invoice = $request->id;
        }

        $invo = invoices::find($invoice);
        $file= invoice_attachments::where('invoice_id',$invoice)->first();

        if($request->id_archive == 2 ){
            $invo->delete();
            return redirect()->back()->with('success', 'تم نقل الفاتورة الى الارشيف بنجاح');
        }else{
            if(!empty($file->invoice_numper)){
                storage::disk('public_uploads')->deleteDirectory($file->invoice_numper);
            }

            $invo->forceDelete();

            return redirect()->back()->with('success','تم حذف الفاتورة بنجاح');

        }

        // dd($file->invoice_numper);

    }

    public function status_update(Request $request,$id){

        // dd($request->all(), $id);
        $invoices = invoices::find($id);
        $validate = $request->validate([
            'status' => 'required',
            'payment_date' => 'required',
        ],[
            'status.required' => 'يجب اختيار الحالة',
            'payment_date.required' => 'يجب ادخال تاريخ الدفع',
        ]);

        if($request->status == '1'){
            $invoices->update([
                'status' => 'مدفوعة',
                'value_status' => '1',
                'Payment_Date'=> $request->payment_date,
                'user' => Auth::user()->name,
                'user_id'=>Auth::user()->id,
            ]);
            invoices_details::create([
                'invoice_id' => $id,
                'invoice_numper' => $invoices->invoice_number,
                'product' => $invoices->product,
                'section' => $invoices->section_id,
                'status' => "مدفوعة",
                'value_status' => 1,
                'Payment_Date'=> $request->payment_date,
                'note' => $invoices->note,
                'user' => Auth::user()->name,
            ]);

        }elseif($request->status == '3'){
            $invoices->update([
                'status' => 'مدفوعة جزئيا',
                'value_status' => '3',
                'Payment_Date'=> $request->payment_date,
                'user' => Auth::user()->name,
                'user_id'=>Auth::user()->id,
            ]);
            invoices_details::create([
                'invoice_id' => $id,
                'invoice_numper' => $invoices->invoice_number,
                'product' => $invoices->product,
                'section' => $invoices->section_id,
                'status' => "مدفوعة جزئيا",
                'value_status' => 3,
                'Payment_Date'=> $request->payment_date,
                'note' => $invoices->note,
                'user' => Auth::user()->name,
            ]);
    }else{
        abort(404);
    }
    return redirect('/invoices')->with('success','تم تعديل الحالة بنجاح');

    }
}
