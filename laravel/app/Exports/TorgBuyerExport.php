<?php

namespace App\Exports;

use App\Models\ADV\AdvTorgPost;
use App\Models\Buyer\BuyerPacksOrders;
use App\Models\Regions\Regions;
use App\Models\Torg\TorgBuyer;
use Carbon\Carbon;
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
            return TorgBuyer::select('id', 'login', 'isactive_web', 'orgname', 'name', 'obl_id', 'last_ip', 'phone', 'phone2', 'phone3', 'email')
                ->where('obl_id', $this->data['obl_id'])
                ->get();
        }

        if ($this->data['email_filter'] != null){
            return TorgBuyer::select('id', 'login', 'isactive_web', 'orgname', 'name', 'obl_id', 'last_ip', 'phone', 'phone2', 'phone3', 'email')
                ->where('login', $this->data['email_filter'])
                ->get();
        }

        if ($this->data['phone_filter'] != null){
            return TorgBuyer::select('id', 'login', 'isactive_web', 'orgname', 'name', 'obl_id', 'last_ip', 'phone', 'phone2', 'phone3', 'email')
                ->where('phone', $this->data['phone_filter'])
                ->orWhere('phone2', $this->data['phone_filter'])
                ->orWhere('phone3', $this->data['phone_filter'])
                ->get();
        }

        if ($this->data['name_filter'] != null){
            return TorgBuyer::select('id', 'login', 'isactive_web', 'orgname', 'name', 'obl_id', 'last_ip', 'phone', 'phone2', 'phone3', 'email')
                ->where('name', 'like', '%' . $this->data['name_filter'] . '%')
                ->get();
        }

        if ($this->data['id_filter'] != null) {
            return TorgBuyer::select('id', 'login', 'isactive_web', 'orgname', 'name', 'obl_id', 'last_ip', 'phone', 'phone2', 'phone3', 'email')
                ->where('id', $this->data['id_filter'])
                ->get();
        }

        if ($this->data['ip_filter'] != null) {
            return TorgBuyer::select('id', 'login', 'isactive_web', 'orgname', 'name', 'obl_id', 'last_ip', 'phone', 'phone2', 'phone3', 'email')
                ->where('last_ip', $this->data['ip_filter'])
                ->get();
        }

        if ($this->data['obl_id'] != null && $this->data['email_filter'] != null){
            return TorgBuyer::select('id', 'login', 'isactive_web', 'orgname', 'name', 'obl_id', 'last_ip', 'phone', 'phone2', 'phone3', 'email')
                ->where('obl_id', $this->data['obl_id'])
                ->where('login', $this->data['email_filter'])
                ->get();
        }

        if ($this->data['obl_id'] != null && $this->data['phone_filter'] != null){
            return TorgBuyer::select('id', 'login', 'isactive_web', 'orgname', 'name', 'obl_id', 'last_ip', 'phone', 'phone2', 'phone3', 'email')
                ->where('obl_id', $this->data['obl_id'])
                ->where('phone', $this->data['phone_filter'])
                ->orWhere('phone2', $this->data['phone_filter'])
                ->orWhere('phone3', $this->data['phone_filter'])
                ->get();
        }

        return TorgBuyer::select('id', 'login', 'isactive_web', 'orgname', 'name', 'obl_id', 'last_ip', 'phone', 'phone2', 'phone3', 'email')
                ->get();
    }

    public function map($torgBuyer): array
    {
        /* активный или нет пользователь */
        $is_active = $torgBuyer->isactive_web;
        $active = 'Да';
        if ($is_active == 0) {
            $active = 'Нет';
        }

        $region = $torgBuyer->obl_id == 0 ? $region = ['name' => 'Украина']
            : $region = Regions::where('id', $torgBuyer->obl_id)->get('name')->toArray()[0];

        /* всего пакетов */
        $all_packs_count = BuyerPacksOrders::where('user_id', $torgBuyer->id)->get()->count();
        $all_packs = BuyerPacksOrders::where('user_id', $torgBuyer->id)->get();

        /* количество активыных объявлений */
        $active_pack = 0;
        foreach ($all_packs as $pack) {
            $start = $pack->stdt;
            $end = $pack->endt;
            $now = Carbon::now();
            if ($start <= $now && $end >= $now){
                $active_pack++;
            }
        }
        /* объявлений всего */
        $posts = AdvTorgPost::where('author_id', $torgBuyer->id)->get()->count();

        return [
            $torgBuyer->id,
            $torgBuyer->login,
            $active,
            $torgBuyer->orgname,
            $torgBuyer->name,
            $region['name'],
            $torgBuyer->last_ip,
            $torgBuyer->phone,
            $torgBuyer->phone2,
            $torgBuyer->phone3,
            $torgBuyer->email,
            $active_pack,
            $all_packs_count,
            $posts,
        ];
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
            "Активных пакетов",
            "Пакетов всего",
            "Объявлений",
        ];
    }
}
