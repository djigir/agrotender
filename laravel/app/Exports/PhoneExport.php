<?php

namespace App\Exports;

use App\Models\Torg\TorgBuyer;
use Maatwebsite\Excel\Concerns\FromCollection;

class PhoneExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return TorgBuyer::select('phone', 'phone2', 'phone3')->get();
    }

}
