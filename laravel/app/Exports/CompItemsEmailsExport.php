<?php

namespace App\Exports;

use App\Models\Comp\CompItems;
use Maatwebsite\Excel\Concerns\FromCollection;

class CompItemsEmailsExport implements FromCollection
{
    protected $comp_id = [];

    public function __construct($comp_id)
    {
        $this->comp_id = $comp_id;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return CompItems::all();
    }
}
