<?php

namespace App\Http\Sections\FastAccess;

use AdminColumn;
use AdminColumnFilter;
use AdminDisplay;
use AdminDisplayFilter;
use AdminForm;
use AdminFormElement;
use App\Models\Buyer\BuyerTarifPacks;
use App\Models\Comp\CompTgroups;
use App\Models\Torg\TorgBuyer;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use SleepingOwl\Admin\Contracts\Display\DisplayInterface;
use SleepingOwl\Admin\Contracts\Form\FormInterface;
use SleepingOwl\Admin\Contracts\Initializable;
use SleepingOwl\Admin\Display\Column\Url;
use SleepingOwl\Admin\Display\ControlLink;
use SleepingOwl\Admin\Facades\Admin;
use SleepingOwl\Admin\Facades\FormElement;
use SleepingOwl\Admin\Form\Buttons\Cancel;
use SleepingOwl\Admin\Form\Buttons\FormButton;
use SleepingOwl\Admin\Form\Buttons\Save;
use SleepingOwl\Admin\Form\Buttons\SaveAndClose;
use SleepingOwl\Admin\Form\Buttons\SaveAndCreate;
use SleepingOwl\Admin\Form\Columns\Column;
use SleepingOwl\Admin\Section;


/**
 * Class CompItems
 *
 * @property \App\Models\Comp\CompItems $model
 *
 * @see https://sleepingowladmin.ru/#/ru/model_configuration_section
 */
class CompItems extends Section implements Initializable
{
    const TRADER_SELL = 100;
    const TRADER_BUYER = 200;
    const PACKAGES = [
        0 => 'Стандарт',
        1 => 'Премиум',
        2 => 'ТОП',
    ];

    const PACKAGES_STYLE = [
        0 => 'black',
        1 => '#dda216',
        2 => '#b6581b',
    ];

    /**
     * @var bool
     */
    protected $checkAccess = false;

    /**
     * @var string
     */
    protected $title = 'Компании';

    /**
     * @var string
     */
    protected $title_comp = '';

    /**
     * @var string
     */
    protected $alias;

    /**
     * Initialize class.
     */
    public function initialize()
    {
//        $this->addToNavigation()->setPriority(100)->setIcon('fa fa-lightbulb-o');
    }

    public function getEditTitle()
    {
        return "Редактировать {$this->title_comp}";
    }


    /**
     * @param array $payload
     *
     * @return DisplayInterface
     */
    public function onDisplay($payload = [])
    {
        $per_page = (int)request()->get("paginate") == 0 ? 25 : (int)request()->get("paginate");
        $columns = [
            AdminColumn::checkbox('')->setOrderable(false)->setWidth('50px'),
            AdminColumn::custom('ID', function(\Illuminate\Database\Eloquent\Model $model) {
                return "<a href='{$model->companyLink()}' target='_blank'>{$model->getKey()}</a>";
            })->setWidth('90px')->setHtmlAttribute('class', 'text-center')->setOrderable('id'),

            AdminColumn::image('logo_file', 'Лого')->setImageWidth('48px'),
            AdminColumn::link('title', 'Компания/Имя', 'torgBuyer.name')
                ->setOrderable(function($query, $direction) {
                    $query->orderBy('id', $direction);
                })->setWidth('200px'),

            AdminColumn::text('email', 'E-mail')->setWidth('200px')->setHtmlAttribute('class', 'text-center'),

            AdminColumn::custom('Дата рег./Вход', function (\Illuminate\Database\Eloquent\Model $model){
                $add_date = Carbon::parse($model->add_date)->format('Y-m-d');
                $last_login = Carbon::parse($model['torgBuyer']['last_login'])->format('Y-m-d');

                return $add_date.' / '.$last_login;
            })->setWidth('200px')->setHtmlAttribute('class', 'text-center'),

            AdminColumn::custom('П/К/У', function (\Illuminate\Database\Eloquent\Model $model) {
                return "<a class='comp_items_adverts' href='{$model->AdvertsType()}?typeAdverts[type_id]=2&typeAdverts[comp_id]={$model->getKey()}' target='_blank'>{$model['advTorgPosts']->where('type_id', 2)->count()}</a> /
                        <a class='comp_items_adverts' href='{$model->AdvertsType()}?typeAdverts[type_id]=1&typeAdverts[comp_id]={$model->getKey()}' target='_blank'>{$model['advTorgPosts']->where('type_id', 1)->count()}</a> /
                        <a class='comp_items_adverts' href='{$model->AdvertsType()}?typeAdverts[type_id]=3&typeAdverts[comp_id]={$model->getKey()}' target='_blank'>{$model['advTorgPosts']->where('type_id', 3)->count()}</a>
                        ";
            })->setWidth('120px')->setHtmlAttribute('class', 'text-center'),
        ];


        $display = AdminDisplay::datatables()
            ->setName('firstdatatables')
            ->setOrder([[1, 'desc']])
            ->setDisplaySearch(false)
            ->setColumns($columns)
            ->setHtmlAttribute('class', 'table-primary table-hover th-center')
            ->setFilters(
                AdminDisplayFilter::custom('id')->setCallback(function ($query, $value) {
                    $query->where('id', $value);
                }),

                AdminDisplayFilter::custom('comp_name')->setCallback(function ($query, $value) {
                    $query->where('title', 'like', '%' . $value . '%');
                }),

                AdminDisplayFilter::custom('obl_id')->setCallback(function ($query, $value) {
                    $query->where('obl_id', $value);
                }),


                AdminDisplayFilter::custom('avail')->setCallback(function ($query, $value) {
                    if($value == 100){
                        $query->where('trader_price_sell_avail', 1);
                    }

                    if($value == 200){
                        $query->where('trader_price_avail', 1);
                    }
                }),

                AdminDisplayFilter::custom('email')->setCallback(function ($query, $value) {
                    $query->whereHas('torgBuyer', function ($query) use ($value) {
                        $query->where('login', $value);
                    });
                })
            );

        $display->getColumnFilters()->setPlacement('card.heading');

        $button = new \SleepingOwl\Admin\Display\ControlLink(function (\Illuminate\Database\Eloquent\Model $model) {
            $WWWHOST = 'https://agrotender.com.ua/';
            return $WWWHOST."buyerlog.html?action=dologin0&buyerlog=".stripslashes($model['torgBuyer']['login'])."&buyerpass=".stripslashes($model['torgBuyer']['passwd']);
        }, '', 50);

        $button->setIcon('fas fa-user-lock');
        $button->setHtmlAttributes(['target' => '_blank', 'class' => 'btn-success btn btn-xs']);

        $display->getColumns()->getControlColumn()->addButton($button);

        return $display->paginate($per_page);

    }

    /**
     * @param int|null $id
     * @param array $payload
     *
     * @return FormInterface
     */
    public function onEdit($id = null, $payload = [])
    {
        $this->title_comp = $this->model_value['title'];

        $form = AdminForm::card()->addBody([
            AdminFormElement::columns()->addColumn([
                AdminFormElement::text('title', 'Название')->required(),
                AdminFormElement::image('logo_file', 'Лого')->setReadonly(true),
                AdminFormElement::html('<span>Таблица закупок:</span>'),
                AdminFormElement::html('<hr>'),

                AdminFormElement::select('trader_price_avail', 'Активна')
                    ->setOptions([
                        0 => 'Нет',
                        1 => 'Да',
                    ]),

                AdminFormElement::select('trader_premium', 'Премиум')
                    ->setOptions([
                        0 => 'Нет',
                        1 => 'Да',
                        2 => 'Премиум +'
                    ]),

                AdminFormElement::html('<span>Таблица форвардов:</span>'),
                AdminFormElement::html('<hr>'),

                AdminFormElement::select('trader_price_forward_avail', 'Активна')
                    ->setOptions([
                        0 => 'Нет',
                        1 => 'Да',
                    ]),

                AdminFormElement::select('trader_premium_forward', 'Премиум')
                    ->setOptions([
                        0 => 'Нет',
                        1 => 'Да',
                    ]),

                AdminFormElement::select('site_pack_id', 'Пакет размещения')
                    ->setModelForOptions(BuyerTarifPacks::class)
                    ->setLoadOptionsQueryPreparer(function($element, $query) {
                        return $query;
                    })
                    ->setDisplay('title'),
            ], 'col-xs-12 col-sm-6 col-md-6 col-lg-3')
        ]);

        $form->getButtons()->setButtons([
            'save'  => new Save(),
            'save_and_close'  => new SaveAndClose(),
            'cancel'  => (new Cancel()),
        ]);

        return $form;
    }

    /**
     * @return FormInterface
     */
    /*public function onCreate($payload = [])
    {
        return $this->onEdit(null, $payload);
    }*/

    /**
     * @return bool
     */
    public function isDeletable(Model $model)
    {
        return true;
    }

    /**
     * @return void
     */
    public function onRestore($id)
    {
        // remove if unused
    }
}
