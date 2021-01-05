<?php

namespace App\Exports;

use App\Models\Torg\TorgBuyer;
use Maatwebsite\Excel\Concerns\FromCollection;

class TorgBuyerExport implements FromCollection
{
    protected $users_id = [];

    public function __construct($users_id)
    {
        $this->users_id = $users_id;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        dd(__METHOD__);
        return TorgBuyer::all();
    }
}
