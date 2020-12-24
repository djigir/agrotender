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

    public function pyBalance()
    {
        return $this->hasMany(PyBalance::class, 'bill_id', 'id');
    }
}
