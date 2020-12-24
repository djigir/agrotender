<?php

namespace App\Models\Py;

use Illuminate\Database\Eloquent\Model;

class PyActions extends Model
{
    protected $table = 'py_actions';

    protected $fillable = [
        'id', 'buyer_id', 'type_id', 'serv_id', 'pack_id',
        'invoice_id', 'sum_tot', 'sum_pay', 'add_date',
        'payercode', 'paycurrency', 'paydescr',
    ];

}
