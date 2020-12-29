<?php

namespace App\Http\Sections\UserManagement;

use AdminColumn;
use AdminColumnFilter;
use AdminDisplay;
use AdminForm;
use AdminFormElement;
use App\Models\Py\PyBillAddr;
use App\Models\Py\PyBillFirm;
use App\Services\BaseServices;
use Illuminate\Database\Eloquent\Model;
use SleepingOwl\Admin\Contracts\Display\DisplayInterface;
use SleepingOwl\Admin\Contracts\Form\FormInterface;
use SleepingOwl\Admin\Contracts\Initializable;
use SleepingOwl\Admin\Form\Buttons\Cancel;
use SleepingOwl\Admin\Form\Buttons\Save;
use SleepingOwl\Admin\Form\Buttons\SaveAndClose;
use SleepingOwl\Admin\Form\Buttons\SaveAndCreate;
use SleepingOwl\Admin\Section;

/**
 * Class PyBill
 *
 * @property \App\Models\Py\PyBill $model
 *
 * @see https://sleepingowladmin.ru/#/ru/model_configuration_section
 */
class PyBill extends Section implements Initializable
{
    /**
     * @var bool
     */
    protected $checkAccess = false;

    /**
     * @var string
     */
    protected $title = 'Пополнение пользователей';

    /**
     * @var string
     */
    protected $alias;

    /**
     * Initialize class.
     */
    public function initialize()
    {
        $this->addToNavigation()->setPriority(100)->setIcon('fa fa-lightbulb-o');
    }
    const PAYMENTH_TYPE = [
        1 => 'Приват 24',
        2 => 'Карта',
        3 => 'По счету',
    ];

    const STATUS = [
        -1 => "Отменен",
        0 => "Новый",
        1 => "Приостановлен",
        2 => "В обработке",
        3 => "Выполнен"
    ];

    const STATUS_AKT = [
        0 => '',
        1 => 'Нужен',
        2 => 'Загружен',
    ];


    /**
     * @param array $payload
     *
     * @return DisplayInterface
     */
    public function onDisplay($payload = [])
    {
        $columns = [
            AdminColumn::text('id', '№')->setWidth('60px')->setOrderable(false),
            AdminColumn::text('add_date', 'Дата')->setOrderable(false),
            AdminColumn::text('torgBuyer.login.', 'Логин')->setOrderable(false),
            AdminColumn::text('torgBuyer.name.', 'Пользователь')->setOrderable(false),

            AdminColumn::custom('Метод', function (\Illuminate\Database\Eloquent\Model $model){
                $paymeth_type = self::PAYMENTH_TYPE;
                return "<div class='row-text'>{$paymeth_type[$model->paymeth_type]}</div>";
            }),

            AdminColumn::custom('Физ./Юр.', function (\Illuminate\Database\Eloquent\Model $model) {
                $orgtype = $model->orgtype == 1 ? 'Юр. лицо' : 'Физ. лицо';
                return "<div class='row-text'>{$orgtype}</div>";
            }),

            AdminColumn::custom('№ док', function (\Illuminate\Database\Eloquent\Model $model) {
                $file = 'https://agrotender.com.ua/';
                $doc = '';
                if($model['pyBillDoc'] != null){
                    if($model->id != 0){
                        $model['pyBillDoc']->where('bill_id', $model->id);
                    }

                    if($model->buyer_id != 0){
                        $model['pyBillDoc']->where('buyer_id', $model->buyer_id);
                    }
                    $file .= $model['pyBillDoc'][0]['filename'];
                    $doc = 'Счет №'.$model['pyBillDoc'][0]['bill_id'];
                }

                return "<div class='row-text'><a href='{$file}' target='_blank'>{$doc}</a></div>";
            }),


            AdminColumn::custom('Статус', function (\Illuminate\Database\Eloquent\Model $model) {
                $style = '';
                $status = self::STATUS;
                if($model->status == 0){
                    $style = 'color:red';
                }
                return "<div style='{$style}' class='row-text'>{$status[$model->status]}</div>";
            }),

            AdminColumn::text('amount', 'Сумма')->setOrderable(false)->setWidth('70px'),

            AdminColumn::custom('Акт', function (\Illuminate\Database\Eloquent\Model $model) {
                $akt = '-';
                $aktstatus = [
                    1 => 'Нужен',
                    2 => 'Загружен',
                ];

                if($model->aktstatus != 0){
                    $akt = $aktstatus[$model->aktstatus];
                }

                return "<div class='row-text'>{$akt}</div>";
            })->setWidth('70px'),

            AdminColumn::custom('Плательщик', function (\Illuminate\Database\Eloquent\Model $model) {
                $payer = $model['pyBillFirm']['id'] != 0 ? $model['pyBillFirm']['otitle'] : '';
                return "<div class='row-text'>{$payer}</div>";
            }),
        ];

        $display = AdminDisplay::datatables()
            ->setName('firstdatatables')
            ->setOrder([[0, 'asc']])
//            ->setDisplaySearch(true)
            ->paginate(25)
            ->setColumns($columns)
            ->setHtmlAttribute('class', 'table-primary table-hover th-center')
        ;

        $display->setColumnFilters([
            AdminColumnFilter::text()->setColumnName('id')->setPlaceholder('по ID'),
            AdminColumnFilter::select()
                ->setOptions(self::PAYMENTH_TYPE)
                ->setLoadOptionsQueryPreparer(function($element, $query) {
                    return $query;
                })
                ->setDisplay('paymeth_type')
                ->setColumnName('paymeth_type')
                ->setPlaceholder('Метод'),
            AdminColumnFilter::select()
                ->setOptions(self::STATUS)
                ->setLoadOptionsQueryPreparer(function($element, $query) {
                    return $query;
                })
                ->setDisplay('status')
                ->setColumnName('status')
                ->setPlaceholder('Статус'),
            AdminColumnFilter::select()
                ->setOptions(self::STATUS_AKT)
                ->setLoadOptionsQueryPreparer(function($element, $query) {
                    return $query;
                })
                ->setDisplay('aktstatus')
                ->setColumnName('aktstatus')
                ->setPlaceholder('Статус акт'),
        ]);

        $display->setApply(function ($query)
        {
            $query->orderBy('add_date', 'desc');
        });

        $display->getColumnFilters()->setPlacement('card.heading');

        return $display;
    }

    /**
     * @param int|null $id
     * @param array $payload
     *
     * @return FormInterface
     */
    public function onEdit($id = null, $payload = [])
    {
        $regions = ["Украина", "АР Крым",
            "Винницкая область", "Волынская область", "Днепропетровская область",
            "Донецкая область", "Житомирская область", "Закарпатская область",
            "Запорожская область", "Ивано-франковская область", "Киевская область",
            "Кировоградская область", "Луганская область", "Львовская область", "Николаевская область",
            "Одесская область", "Полтавская область", "Ровенская область", "Сумская область",
            "Тернопольская область", "Харьковская область", "Херсонская область",
            "Хмельницкая область", "Черкасская область", "Черниговская область", "Черновицкая область"
        ];
        $orgtype = $this->model_value['orgtype'] == 1 ? 'Юр. лицо' : 'Физ. лицо';
        $paymeth_type = self::STATUS;
        $status = self::PAYMENTH_TYPE;

        $pyBillAddr = PyBillAddr::where('id', $this->model_value['payer_addr_id'])->first();
        $pyBill = PyBillFirm::where('id', $this->model_value['payer_ooo_id'])->first();
        $getPyBillFirm = PyBillFirm::where('buyer_id', $this->model_value['buyer_id'])->orderBy('payer_type')->orderBy('otitle')->pluck('otitle', 'id');
        $getPyBillAddr = PyBillAddr::select('add_date', 'id', 'city', 'address')->orderBy('add_date')->get();

        foreach ($getPyBillAddr as $bill_addr){
            $addresses[$bill_addr->id] = $bill_addr->city.$bill_addr->address;
        }

        if($pyBillAddr){
            $value = $regions[$pyBillAddr->obl_id] .' , '.$pyBillAddr->zip .' , '.$pyBillAddr->city .' , '.$pyBillAddr->address;
        }

        $address = AdminFormElement::html("<div class='form-group form-element-text'>
                <label for='id' class='control-label'>
                        Указанный адрес отправки док
                </label>
                <input type='text' value='{$value}' readonly='readonly' class='form-control'>
            </div>");

        $payer = AdminFormElement::html("
            <div class='form-group form-element-text'>
                <label for='amount' class='control-label'>
                        Указанный Плательщик
                </label>
                <textarea rows='7' style='width: 750px' class='form-control' type='text' readonly='readonly'>
{$orgtype}: {$pyBill->otitle}
Юр.адрес: {$regions[$pyBill->obl_id]}, {$pyBill->zip} {$pyBill->city}, {$pyBill->address}
ИНН: {$pyBill->oipn}
ОКПО: {$pyBill->okode}
                </textarea>
           </div>");

        $form = AdminForm::card()->addBody([
            AdminFormElement::columns()->addColumn([
                AdminFormElement::number('amount', 'Сумма счета'),
                AdminFormElement::select('aktstatus', 'Потребность акта')
                    ->setOptions([
                        0 => '',
                        1 => 'Нужен',
                        2 => 'Загружен',
                    ])->setDefaultValue($this->model_value['aktstatus']),
                AdminFormElement::select('payer_addr_id', 'Сменить адрес')->setOptions($addresses)->setDefaultValue($addresses[$this->model_value['payer_addr_id']]),
                AdminFormElement::select('payer_ooo_id', 'Задать Плательщика')->setOptions($getPyBillFirm->toArray()),

            ], 'col-xs-12 col-sm-6 col-md-4 col-lg-4')->addColumn([
                AdminFormElement::text('add_date', 'Дата счета')->setReadonly(true),
                AdminFormElement::html("
                <div class='form-group form-element-text'>
                <label for='id' class='control-label'>
                        Тип оплаты
                </label>
                <input class='form-control' type='text' id='paymeth_type' name='paymeth_type' value='{$paymeth_type[$this->model_value['paymeth_type']]}' readonly='readonly'>
                </div>"),
                AdminFormElement::html("
                <div class='form-group form-element-text'>
                <label for='id' class='control-label'>
                        Статус оплаты
                </label>
                <input class='form-control' type='text' id='status' name='status' value='{$status[$this->model_value['status']]}' readonly='readonly'>
                </div>"),
                $address,
                $payer,
            ], 'col-xs-12 col-sm-6 col-md-8 col-lg-8'),
        ]);


        $form->getButtons()->setButtons([
            'save'  => new Save(),
            'save_and_close'  => new SaveAndClose(),
            'save_and_create'  => new SaveAndCreate(),
            'cancel'  => (new Cancel()),
        ]);

        return $form;
    }

    /**
     * @return FormInterface
     */
//    public function onCreate($payload = [])
//    {
//        return $this->onEdit(null, $payload);
//    }

    /**
     * @return bool
     */
//    public function isDeletable(Model $model)
//    {
//        return true;
//    }

    /**
     * @return void
     */
    public function onRestore($id)
    {
        // remove if unused
    }
}
