<?php

namespace App\Models\Py;

use App\Models\Torg\TorgBuyer;
use Illuminate\Database\Eloquent\Model;

class PyBill extends Model
{
    protected $table = 'py_bill';

    public $timestamps = false;

    protected $fillable = [
        'id', 'buyer_id', 'paymeth_type', 'orgtype',
        'serv_id', 'status', 'aktstatus', 'amount',
        'add_date', 'payer_ooo_id', 'payer_addr_id', 'tst_st'
    ];

    public function torgBuyer()
    {
        return $this->hasMany(TorgBuyer::class,'id', 'buyer_id');
    }


    public function pyBillFirm()
    {
        return $this->hasMany(PyBillFirm::class,'id', 'payer_ooo_id');
    }


    public function pyBalance()
    {
        return $this->belongsTo(PyBalance::class, 'bill_id', 'id');
    }


    public function pyBillDoc()
    {
        return $this->hasOne(PyBillDoc::class, 'bill_id', 'id');
    }

}
