<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class InvoicesResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        // return parent::toArray($request);

        return [
            "numper" => $this->id, // this is id
            "invoice_number"=> $this->invoice_number,
            "Invoice_date"=>  $this->Invoice_Date,
            "due_date"=>$this->due_date,
            "product"=>  $this->product,
            "section_id"=> $this->section_id,
            "Amount_collection"=>  $this->Amount_collection,
            "Amount_Commission"=>  $this->Amount_Commission,
            "discount"=>  $this->discount,
            "rate_vat"=>  $this->rate_vat,
            "value_vat"=> $this->value_vat,
            "total"=>  $this->total,
            "status"=>  $this->status,
            "value_status"=> $this->value_status,
            "note"=> $this->note,
            "Payment_Date"=>$this->Payment_Date,
            "user"=> $this->user,
            "user_id"=> $this->user_id,
            "deleted_at"=> $this->deleted_at,
        ];
    }
}
