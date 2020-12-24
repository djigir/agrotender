<?php

namespace App\Models\Py;

use Illuminate\Database\Eloquent\Model;

class PyBillAddr extends Model
{
    protected $table = 'py_bill_addr';

    public $timestamps = false;

    protected $fillable = [
        'id', 'buyer_id', 'addr_type',
        'add_date', 'obl_id', 'city',
        'zip', 'address',
    ];
}
