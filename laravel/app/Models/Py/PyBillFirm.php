<?php

namespace App\Models\Py;

use Illuminate\Database\Eloquent\Model;

class PyBillFirm extends Model
{
    protected $table = 'py_bill_firm';

    public $timestamps = false;

    protected $fillable = [
        'id', 'buyer_id', 'payer_type',
        'bill_addr_id', 'add_date', 'obl_id', 'city',
        'zip', 'address', 'otitle', 'oipn', 'okode',
    ];
}
