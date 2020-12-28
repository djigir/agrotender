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
    protected $title = 'Зарегистрированые пользователи';

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

            AdminColumn::text('', 'Баланс')
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
                        <a class='comp_items_adverts' href='#'>{$model['buyerPacksOrders']->count()}</a>
                    </div>";
            })->setWidth('88px')->setHtmlAttribute('class', 'text-center'),

            AdminColumn::custom('Объявл.', function (\Illuminate\Database\Eloquent\Model $model) {
                return "<div class='row-text'>
                        <a class='comp_items_adverts' href='{$model->TorgBuyerAdverts()}?TorgBuyerAdverts[author_id]={$model->id}'>{$model['advTorgPost']->count()}</a>
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
                        <a href='#'>{$ban}</a>
                    </div>";
            })->setHtmlAttribute('class', 'text-center'),

            AdminColumn::custom('Действие', function (\Illuminate\Database\Eloquent\Model $model) {
                return "<div class='row-text'>
                        <a href='' class='btn btn-success small'>Войти</a>
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
                ->setPlaceholder('Все области'),

            AdminColumnFilter::text()
                ->setColumnName('email')
                ->setPlaceholder('Фильтровать по E-mail:'),

            AdminColumnFilter::text()
                ->setColumnName('phone')
                ->setPlaceholder('по Тел.'),

            AdminColumnFilter::text()
                ->setColumnName('name')
                ->setPlaceholder('по Имени'),

            AdminColumnFilter::text()
                ->setColumnName('id')
                ->setPlaceholder('по ID'),

            AdminColumnFilter::text()
                ->setColumnName('last_ip')
                ->setPlaceholder(' по IP'),

            AdminColumnFilter::range()->setFrom(
                AdminColumnFilter::text()->setPlaceholder('Объявл. от')
            )->setTo(
                AdminColumnFilter::text()->setPlaceholder('До')
            )->setCallback(function ($value, $query){
                $request = \request()->get('columns')[6]['search']['value'];
                $from = stristr($request, ':', ':');
                $to = substr(strrchr($request, ':'), 1);

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
                AdminFormElement::text('login', 'Логин')
                    ->required(),
                AdminFormElement::html('<hr>'),

                AdminFormElement::text('name', 'Ф.И.О'),

                AdminFormElement::text('orgname', 'Организация'),

                AdminFormElement::text('addres', 'Адрес'),
                AdminFormElement::text('regions.name', 'Город'),
                AdminFormElement::text('phone', 'Телефон'),
                AdminFormElement::text('phone2', 'Телефон2'),
                AdminFormElement::text('phone3', 'Телефон3'),

                AdminFormElement::text('email', 'E-Mail'),

                AdminFormElement::text('compItems.www', 'Веб-страница'),

                AdminFormElement::text('avail_adv_posts', 'Сейчас доступно бесплатно объявл.'),

                AdminFormElement::text('max_adv_posts', 'Максимальное кол-во объявл.'),


                AdminFormElement::html("<div class='form-group form-element-text'><label for='s' class='control-label'>
                        Текущее кол-во объявлений
                    </label> <input class='form-control' type='text' id='s' name='s' value='{$this->model_value['advTorgPost']->count()}' readonly='readonly'></div>"),

                AdminFormElement::html("<div class='form-group form-element-text'><label for='s' class='control-label'>
                        Текущее кол-во активных объяв.
                    </label> <input class='form-control' type='text' id='s' name='s' value='{$this->model_value['advTorgPost']->where('active', 1)->count()}' readonly='readonly'></div>"),


                AdminFormElement::html("<div class='form-group form-element-text'><label for='s' class='control-label'>
                        Доступно к размещению объявлений
                    </label> <input class='form-control' type='text' id='s' name='s' value='10' readonly='readonly'></div>"),


                AdminFormElement::select('isactive_web')
                    ->setOptions([
                        1 => 'Да',
                        0 => 'Нет'
                    ]),

                AdminFormElement::textarea('comments', 'Комментарии')
                    ->setRows(5),

                AdminFormElement::html("<span style='color: gray; font-weight:bold; margin-top: 1rem;'>
                        Изменение пароля пользователя
                    </span> <hr>"),

                AdminFormElement::password('passwd', 'Новый пароль')->hashWithBcrypt(),

            ], 'col-xs-12 col-sm-6 col-md-9 col-lg-9')->addColumn([
                AdminFormElement::text('id', 'ID')->setReadonly(true),
            ], 'col-xs-12 col-sm-6 col-md-3 col-lg-3'),
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
    public function onCreate($payload = [])
    {
        return $this->onEdit(null, $payload);
    }

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
