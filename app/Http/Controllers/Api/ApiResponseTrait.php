<?php


namespace App\Http\Controllers\Api;
use Illuminate\Support\Facades\Validator;



trait ApiResponseTrait{

    public function apiresponse($data=null , $status=null, $msg=null){

        $data_api = [
            'data' => $data,
            'status'=>$status,
            'massege'=>[$msg],
        ];
        return response($data_api,$status,$msg);


    }
    public function valdition_request($request){

        $validator = Validator::make($request,[

            "invoice_number"=>'required|max:255',
            "Invoice_date"=>'required|max:255',
            "due_date"=>'required|max:255',
            "product"=>'required|max:255',
            "section"=>'required|max:255',
            "Amount_collection"=>'required|integer|digits_between:2,7',
            "Amount_Commission"=>'required|max:255',
            "Discount"=>'required|max:255',
            "rate_vat"=>'required|max:255',
            "value_vat"=>'required|max:255',
            "total"=>'required|max:255',
            "note"=> 'string',
        ],[
            'Amount_collection.digits_between' => "the number must not exceed 8 characters",
        ]);

        if($validator->fails()){
            return $this->apiresponse(null,400,[$validator->errors()]);
        }else{
            return $this->apiresponse(null,401,["faild"]);
        }
    }
}
