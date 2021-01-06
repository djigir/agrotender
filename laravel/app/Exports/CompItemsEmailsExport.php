<?php

namespace App\Exports;

use App\Models\Comp\CompItems;
use App\Models\Comp\CompTopicItem;
use Maatwebsite\Excel\Concerns\FromCollection;

class CompItemsEmailsExport implements FromCollection
{
    protected $obl_id;
    protected $section_id;

    public function __construct($obl_id, $section_id)
    {
        $this->obl_id = $obl_id;
        $this->section_id = $section_id;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        dd($this->section_id);
        if ($this->obl_id != null) {
            return CompItems::select('email')->where('obl_id', $this->obl_id)->get();
        }

        if ($this->section_id != null) {
            $section = CompTopicItem::where('topic_id', $this->section_id)->pluck('item_id');
            CompItems::select('email')->whereIn('id', $section)->get();
        }

        return CompItems::select('email')->get();
    }
}
