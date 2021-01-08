<?php

namespace App\Exports;

use App\Models\Comp\CompItems;
use App\Models\Comp\CompTgroups;
use App\Models\Comp\CompTopic;
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
        $comp_on_section = CompTopic::where('menu_group_id', $this->section_id)->pluck('id');
        $comp_item_topic = CompTopicItem::whereIn('topic_id', $comp_on_section)->pluck('item_id');

        if ($this->obl_id != null && $this->section_id != null) {
            return CompItems::select('email')->where('obl_id', $this->obl_id)->whereIn('id', $comp_item_topic)->get();
        }

        if ($this->obl_id != null) {
            return CompItems::select('email')->where('obl_id', $this->obl_id)->get();
        }

        if ($this->section_id != null) {
            return  CompItems::select('email')->whereIn('id', $comp_item_topic)->get();
        }


        return CompItems::select('email')->get();
    }
}
