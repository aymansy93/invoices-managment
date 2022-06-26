<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class invoices_details extends Model
{
    use HasFactory;

    protected $fillable = [
        'invoice_id',
        'invoice_numper',
        'product',
        'section',
        'Payment_Date',
        'status',
        'value_status',
        'note',
        'user',
    ];
}
