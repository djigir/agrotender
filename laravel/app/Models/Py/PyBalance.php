<?php

namespace App\Models\Py;

use Illuminate\Database\Eloquent\Model;

class PyBalance extends Model
{
    protected $table = 'py_balance';

    public $timestamps = false;

    protected $fillable = [
        'id', 'buyer_id', 'bill_id', 'order_id',
        'oper_by', 'oper_debkred', 'kredit_type', 'debit_type',
        'amount', 'add_date',
    ];

    public function pyBill()
    {
        return $this->belongsTo(PyBill::class, 'id', 'bill_id');
    }
}
