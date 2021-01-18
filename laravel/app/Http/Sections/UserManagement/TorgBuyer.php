<?php

namespace App\Http\Sections\UserManagement;

use AdminColumn;
use AdminColumnFilter;
use AdminDisplay;
use AdminForm;
use AdminFormElement;
use App\Models\ADV\AdvTorgPost;
use Illuminate\Database\Eloquent\Model;
use SleepingOwl\Admin\Contracts\Display\DisplayInterface;
use SleepingOwl\Admin\Contracts\Form\FormInterface;
use SleepingOwl\Admin\Contracts\Initializable;
use SleepingOwl\Admin\Form\Buttons\Cancel;
use SleepingOwl\Admin\Form\Buttons\Save;
use SleepingOwl\Admin\Form\Buttons\SaveAndClose;
use SleepingOwl\Admin\Form\Buttons\SaveAndCreate;
use SleepingOwl\Admin\Form\FormElement;
use SleepingOwl\Admin\Section;

/**
 * Class TorgBuyer
 *
 * @property \App\Models\Torg\TorgBuyer $model
 *
 * @see https://sleepingowladmin.ru/#/ru/model_configuration_section
 */
class TorgBuyer extends Section implements Initializable
{
    /**
     * @var bool
     */
    protected $checkAccess = false;

    /**
     * @var string
     */
    protected $title = 'Зарегистрированные пользователи';

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

    /**
     * @param array $payload
     *
     * @return DisplayInterface
     */
    public function onDisplay($payload = [])
    {
        $columns = [
            AdminColumn::text('id', 'ID')
                ->setWidth('80px')
                ->setHtmlAttribute('class', 'text-center'),
            AdminColumn::link('login', 'Логин/Дата регистр.', 'add_date')
                ->setOrderable(function($query, $direction) {
                    $query->orderBy('add_date', $direction);
                })->setHtmlAttribute('class', 'text-center'),

            AdminColumn::boolean('isactive_web', 'Активация'),

            AdminColumn::boolean('smschecked', 'Телефон'),

            AdminColumn::custom('Баланс', function (\Illuminate\Database\Eloquent\Model $model) {
                $balance = $model->getBalance();
                return "<div class='row-text'>
                         {$balance}
                    </div>";
            })
                ->setHtmlAttribute('class', 'text-center'),


            AdminColumn::text('name', 'Ф.И.О')
                ->setHtmlAttribute('class', 'text-center'),

            AdminColumn::text('regions.name', 'Область')
                ->setOrderable(function($query, $direction) {
                    $query->orderBy('obl_id', $direction);
                })
                ->setHtmlAttribute('class', 'text-center'),

            AdminColumn::text('phone', 'Контакты', 'email')
                ->setHtmlAttribute('class', 'text-center'),

            AdminColumn::custom('Пакеты', function (\Illuminate\Database\Eloquent\Model $model){
                return "<div class='row-text'>
                        <a class='comp_items_adverts' href='{$model->TorgBuyerPackOreders()}?TorgBuyerPackOreders[user_id]={$model->id}' user_id='{$model->getKey()}' target='_blank'>{$model['buyerPacksOrders']->count()}</a>
                    </div>";
            })->setWidth('88px')->setHtmlAttribute('class', 'text-center'),

            AdminColumn::custom('Объявл.', function (\Illuminate\Database\Eloquent\Model $model) {
                return "<div class='row-text'>
                        <a class='comp_items_adverts' href='{$model->TorgBuyerAdverts()}?TorgBuyerAdverts[author_id]={$model->id}' target='_blank'>{$model['advTorgPost']->count()}</a>
                    </div>";

            })->setOrderable(function($query, $direction) {
                $query->orderBy('obl_id', $direction);
            })->setWidth('88px')->setHtmlAttribute('class', 'text-center'),

            AdminColumn::custom('Бан', function (\Illuminate\Database\Eloquent\Model $model) {
                $ban = 0;
                if ($model['torgBuyerBan']){
                    $ban = $model['torgBuyerBan']->where('user_id', $model->getKey())->count();
                }
                return "<div class='row-text'>
                        <a href='{$model->TorgBuyerBanRoute()}?GetBanedUser[user_id]={$model->id}' target='_blank'>{$ban}</a>
                    </div>";
            })->setHtmlAttribute('class', 'text-center'),

            AdminColumn::custom('Действие', function (\Illuminate\Database\Eloquent\Model $model) {
                $WWWHOST = 'https://agrotender.com.ua/';
                return "<div class='row-text'>
                        <a href=\"".$WWWHOST."buyerlog.html?action=dologin0&buyerlog=".stripslashes($model->login)."&buyerpass=".stripslashes($model->passwd)."\" target='_blank' class='btn btn-success small'>Войти</a>
                    </div>";
            })->setHtmlAttribute('class', 'text-center'),

        ];

        $display = AdminDisplay::datatables()
            ->setName('firstdatatables')
            ->setOrder([[0, 'desc']])
            ->setDisplaySearch(false)
            ->paginate(25)
            ->setColumns($columns)
            ->setHtmlAttribute('class', 'table-primary table-hover th-center')
            ->setFilters(
                \AdminDisplayFilter::scope('typeAdverts') // ?type=news | ?latest&type=news
            );

        $display->setColumnFilters([
            AdminColumnFilter::select()
                ->setModelForOptions(\App\Models\Regions\Regions::class)
                ->setLoadOptionsQueryPreparer(function($element, $query) {
                    return $query;
                })
                ->setDisplay('name')
                ->setColumnName('obl_id')
                ->setHtmlAttribute('class', 'obl_filter')
                ->setPlaceholder('Все области'),

            AdminColumnFilter::text()
                ->setColumnName('email')
                ->setHtmlAttribute('class', 'email_filter')
                ->setPlaceholder('Фильтровать по E-mail:'),

            AdminColumnFilter::text()
                ->setColumnName('phone')
                ->setHtmlAttribute('class', 'phone_filter')
                ->setPlaceholder('по Тел.'),

            AdminColumnFilter::text()
                ->setColumnName('name')
                ->setOperator('contains')
                ->setHtmlAttribute('class', 'name_filter')
                ->setPlaceholder('по Имени'),

            AdminColumnFilter::text()
                ->setColumnName('id')
                ->setHtmlAttribute('class', 'id_filter')
                ->setPlaceholder('по ID'),

            AdminColumnFilter::text()
                ->setColumnName('last_ip')
                ->setHtmlAttribute('class', 'ip_filter')
                ->setPlaceholder(' по IP'),

            AdminColumnFilter::range()->setFrom(
                AdminColumnFilter::text()->setPlaceholder('Объявл. от')
            )->setTo(
                AdminColumnFilter::text()->setPlaceholder('До')
            )->setCallback(function ($value, $query){
                $request = \request()->get('columns')[6]['search']['value'];
                $from = stristr($request, ':', ':');
                $to = substr(strrchr($request, ':'), 1);
//                if ($from !=null && $to != null){
//                    return $query->where(['id' => function($q)use($from, $to) {
//                        $q->where('author_id', $this->getModelValue()['id'])->whereBetween(\DB::raw('count(id) as posts', [$from, $to]));
//                    }]);
//                }
//                return true;
            })->setHtmlAttribute('class', 'count-adverts-filter')
                ->addStyle('my', asset('/app/assets/css/my-laravel.css')),

        ]);

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


        $form = AdminForm::card()->addBody([
            AdminFormElement::columns()->addColumn([
                AdminFormElement::text('login', 'Логин')->required(),
                AdminFormElement::html('<hr>'),
                AdminFormElement::text('name', 'Ф.И.О'),
                AdminFormElement::text('orgname', 'Организация'),
                AdminFormElement::text('addres', 'Адрес'),
                AdminFormElement::text('regions.name', 'Город'),
                AdminFormElement::text('phone', 'Телефон'),
                AdminFormElement::text('phone2', 'Телефон2'),
                AdminFormElement::text('phone3', 'Телефон3'),
                AdminFormElement::text('email', 'E-Mail'),
            ], 'col-xs-12 col-sm-6 col-md-9 col-lg-6')->addColumn([
                AdminFormElement::text('compItems.www', 'Веб-страница'),
                AdminFormElement::password('passwd', 'Новый пароль')->hashWithBcrypt(),
                AdminFormElement::text('avail_adv_posts', 'Сейчас доступно бесплатно объявл.'),
                AdminFormElement::text('max_adv_posts', 'Максимальное кол-во объявл.'),
                AdminFormElement::select('isactive_web')
                    ->setOptions([
                        1 => 'Да',
                        0 => 'Нет'
                    ]),

                AdminFormElement::ckeditor('comments', 'Комментарии'),

                AdminFormElement::html("<span style='color: gray; font-weight:bold; margin-top: 1rem;'>
                        Изменение пароля пользователя
                    </span> <hr>"),
                AdminFormElement::html("<div class='form-group form-element-text'><label for='s' class='control-label'>
                        Текущее кол-во объявлений
                    </label> <input class='form-control' type='text' id='s' name='s' value='{$this->model_value['advTorgPost']->count()}' readonly='readonly'></div>"),

                AdminFormElement::html("<div class='form-group form-element-text'><label for='s' class='control-label'>
                        Текущее кол-во активных объяв.
                    </label> <input class='form-control' type='text' id='s' name='s' value='{$this->model_value['advTorgPost']->where('active', 1)->count()}' readonly='readonly'></div>"),


                AdminFormElement::html("<div class='form-group form-element-text'><label for='s' class='control-label'>
                        Доступно к размещению объявлений
                    </label> <input class='form-control' type='text' id='s' name='s' value='10' readonly='readonly'></div>"),
            ], 'col-xs-12 col-sm-6 col-md-3 col-lg-6'),
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
    public function onCreate($payload = [])
    {
        return $this->onEdit(null, $payload);
    }

    /**
     * @return bool
     */
    public function isDeletable(Model $model)
    {
        $type = request()->get('type');
        if ($type == 'email_adverts') {
            return false;
        }
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
