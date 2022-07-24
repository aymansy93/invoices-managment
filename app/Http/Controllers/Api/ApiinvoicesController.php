<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Notification;
use App\Notifications\invoicemail;

use App\Http\Resources\InvoicesResource;
use Illuminate\Http\Request;
use App\Models\invoices;
use App\Models\invoices_details;
use App\Models\invoice_attachments;
use App\Models\User;

use Storage;




class ApiinvoicesController extends Controller
{
    //
    use ApiResponseTrait;

    public function index(){

        $invoices = InvoicesResource::collection(invoices::all());

        return $this->apiresponse($invoices,200,['ok']);
    }

    public function show($id){
        $invoices = invoices::find($id);

        if($invoices){
            return $this->apiresponse(new InvoicesResource($invoices),200,['ok']);
        }else{
            return $this->apiresponse(null,404,['invoices Not found']);
        }
    }

    public function store(Request $request){
        // dd( $this->valdition($request->all()));
        $this->valdition_request($request->all());

        $invoices = invoices::create([
            'invoice_number' => $request->invoice_number,
            'invoice_Date' => date('Y-m-d',$request->invoice_Date) ,
            'due_date' => date('Y-m-d',$request->due_date),
            'product' => $request->product,
            'section_id' => $request->section,
            'Amount_collection' => $request->Amount_collection,
            'Amount_Commission' => $request->Amount_Commission,
            'discount' => $request->Discount,
            'rate_vat' => $request->rate_vat,
            'value_vat' => $request->value_vat,
            'total' => $request->total,
            'status' => 'غير مدفوعة',
            'value_status' => '2',
            'note' => $request->note,
            'user' => $request->user,
            'user_id'=>$request->user_id,

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
            'user' => $request->user,
        ]);

        // $user = User::get();
        // Notification::send($user, new invoicemail($invoice_id));

        if($invoices){
            return $this->apiresponse(new InvoicesResource($invoices),201,['save invoices successfully']);
        }else{
            return $this->apiresponse(null,400,['invoices Not found']);
        }
    }

    public function update(Request $request,$id){
        $this->valdition_request($request->all());
        $invoices = invoices::find($id);
        if($invoices){
            $invoices->update([

                'due_date' => date('Y-m-d',$request->due_date),
                'product' => $request->product,
                'section_id' => $request->section,
                'Amount_collection' => $request->Amount_collection,
                'Amount_Commission' => $request->Amount_Commission,
                'discount' => $request->discount,
                'rate_vat' => $request->rate_vat,
                'value_vat' => $request->value_vat,
                'total' => $request->total,
                'status' => 'غير مدفوعة',
                'value_status' => '2',
                'note' => $request->note,
                'user' => $request->user,
                'user_id'=>$request->user_id,
            ]);
            return $this->apiresponse(new InvoicesResource($invoices),201,['update invoices successfully']);

        }else{
            return $this->apiresponse(null,400,['invoices Not found']);
        }
    }

    public function distroy($id){
        $invoices = invoices::find($id);
        if($invoices){
        // dd($invoices);

            $invoices->delete($invoices);

            return $this->apiresponse(null,200,['deleted invoices successfully']);

        }else{

            return $this->apiresponse(null,404,['invoices Not found']);
        }

    }

}
