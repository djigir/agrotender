<?php

namespace App\Models\Py;

use Illuminate\Database\Eloquent\Model;

class PyBalance extends Model
{
    protected $table = 'py_balance';

    protected $fillable = [
        'id', 'buyer_id', 'bill_id',
        'order_id', 'oper_by', 'oper_debkred',
        'debit_type', 'kredit_type', 'amount', 'add_date'
    ];
}
