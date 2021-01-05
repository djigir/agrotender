<?php

namespace App\Models\Py;

use App\Models\Buyer\BuyerTarifPacks;
use App\Models\Torg\TorgBuyer;
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


    /* Relations */

    public function pyBill()
    {
        return $this->hasMany(PyBill::class, 'id', 'bill_id');
    }

    public function torgBuyer()
    {
        return $this->hasOne(TorgBuyer::class, 'id', 'buyer_id');
    }

    public function buyerTarifPacks()
    {
        return $this->hasMany(BuyerTarifPacks::class, 'id', 'debit_type');
    }
}
