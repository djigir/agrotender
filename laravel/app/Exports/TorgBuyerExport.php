<?php

namespace App\Exports;

use App\Models\Torg\TorgBuyer;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class TorgBuyerExport implements FromCollection, WithMapping, WithHeadings
{
    protected $data = [];

    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        if ($this->data['obl_id'] != null) {
//            return TorgBuyer::select('id', 'login', 'isactive', 'orgname', 'name', 'obl_id', 'last_ip', 'phone', 'phone2', 'phone3', 'email','isactive_ban')
//                ->where('obl_id', $this->data['obl_id'])->get();

            return TorgBuyer::with('regions')->where('id', $this->data['obl_id'])->get();
        }
        if ($this->data['email_filter'] != null){
            return TorgBuyer::where('login', $this->data['email_filter']);
        }
        if ($this->data['phone_filter'] != null){
            return TorgBuyer::where('phone', $this->data['phone_filter'])
                ->orWhere('phone2', $this->data['phone_filter'])
                ->orWhere('phone3', $this->data['phone_filter'])->get();
        }
        if ($this->data['name_filter'] != null){
            return TorgBuyer::where('name', $this->data['name_filter'])->get();
        }
        if ($this->data['id_filter'] !=null) {
            return TorgBuyer::find($this->data['id_filter']);
        }
        if ($this->data['ip_filter'] != null) {
            return TorgBuyer::where('last_ip', $this->data['ip_filter'])->get();
        }

        if ($this->data['obl_id'] != null && $this->data['email_filter'] != null){
            return TorgBuyer::where('obl_id', $this->data['obl_id'])
                ->where('login', $this->data['email_filter'])
                ->get();
        }

        if ($this->data['obl_id'] != null && $this->data['phone_filter'] != null){
            return TorgBuyer::where('obl_id', $this->data['obl_id'])
                ->where('phone', $this->data['phone_filter'])
                    ->orWhere('phone2', $this->data['phone_filter'])
                    ->orWhere('phone3', $this->data['phone_filter'])->get();
        }

        return TorgBuyer::all();
    }

    public function map($torgBuyer): array
    {
//        dd($torgBuyer);
        $is_active = $torgBuyer->is_active;
        $active = 'Да';
        if ($is_active == 0) {
            $active = 'Нет';
        }

        $a= [
            $torgBuyer->id,
            $torgBuyer->login,
            $active,
            $torgBuyer->orgname,
            $torgBuyer->name,
            $torgBuyer->regions->name
        ];
        dd($a);
    }

    public function headings(): array
    {
        return [
            "ID",
            "Логин",
            "Активный",
            "Имя организации",
            "Имя",
            "Область",
            "IP",
            "Телефон",
            "Телефон2",
            "Телефон3",
            "Email",
            "Бан",
        ];
    }
}
