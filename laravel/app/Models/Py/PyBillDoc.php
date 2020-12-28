<?php

namespace App\Models\Py;

use Illuminate\Database\Eloquent\Model;

class PyBillDoc extends Model
{
    protected $table = 'py_bill_doc';

    public $timestamps = false;

    protected $fillable = [
        'id', 'buyer_id', 'bill_id', 'doc_type',
        'sum_tot', 'filename', 'add_date',
    ];


    public function pyBill()
    {
        return $this->belongsTo(PyBill::class, 'id', 'bill_id');
    }
}
