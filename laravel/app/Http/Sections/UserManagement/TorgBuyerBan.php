<?php

namespace App\Http\Sections\UserManagement;

use AdminColumn;
use AdminColumnFilter;
use AdminDisplay;
use AdminForm;
use AdminFormElement;
use Carbon\Carbon;
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
 * Class TorgBuyerBan
 *
 * @property \App\Models\Torg\TorgBuyerBan $model
 *
 * @see https://sleepingowladmin.ru/#/ru/model_configuration_section
 */
class TorgBuyerBan extends Section implements Initializable
{
    /**
     * @var bool
     */
    protected $checkAccess = false;

    /**
     * @var string
     */
    protected $title = 'Забаненные пользователи';

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
                ->setWidth('50px')
                ->setHtmlAttribute('class', 'text-center'),

            AdminColumn::text('torgBuyer.id', 'User ID')
                ->setWidth('90px')
                ->setOrderable(function($query, $direction) {
                    $query->orderBy('id', $direction);
                })->setHtmlAttribute('class', 'text-center'),

            AdminColumn::link('torgBuyer.login', 'Логин')
                ->setOrderable(function($query, $direction) {
                    $query->orderBy('user_id', $direction);
                })->setHtmlAttribute('class', 'text-center'),

            AdminColumn::text('torgBuyer.name', 'Ф.И.О.')
                ->setOrderable(function($query, $direction) {
                    $query->orderBy('user_id', $direction);
                })->setHtmlAttribute('class', 'text-center'),

            AdminColumn::text('regions.city', 'Адрес', 'torgBuyer.city')
                ->setOrderable(function($query, $direction) {
                    $query->orderBy('user_id', $direction);
                })->setWidth('120px')->setHtmlAttribute('class', 'text-center'),

            AdminColumn::text('ban_phone', 'Контакты', 'ban_email')
                ->setOrderable(function($query, $direction) {
                        $query->orderBy('ban_phone', $direction);
                    })->setHtmlAttribute('class', 'text-center'),

            AdminColumn::text('add_date', 'Бан от/до', 'end_date')
                ->setWidth('170px')
                ->setHtmlAttribute('class', 'text-center'),

            AdminColumn::text('period_days', 'Срок')
                ->setWidth('80px')
                ->setHtmlAttribute('class', 'text-center'),

            AdminColumn::text('comment', 'Комментарий')
                ->setHtmlAttribute('class', 'text-center'),

            AdminColumn::custom('Статус', function (\Illuminate\Database\Eloquent\Model $model){
                $status_date = Carbon::now();
                $diff_date = $status_date->diffInDays($model->end_date, false);


                $status = $model->is_disabled;

                $is_active = 'Нет актив.';
                $style = '';
                if ($status == 0 && $diff_date > 0) {
                    $is_active = 'Актив.';
                    $style = 'color:red;';
                }
                return "<div class='row-text text-center' style='{$style}'>{$is_active}</div>";
            })->setOrderable(function($query, $direction) {
                $query->orderBy('end_date', $direction);
            })->setHtmlAttribute('class', 'text-center')
                ->setHtmlAttribute('class', 'text-center'),
        ];

        $display = AdminDisplay::datatables()
            ->setName('firstdatatables')
            ->setOrder([[0, 'desc']])
            ->setDisplaySearch(false)
            ->paginate(25)
            ->setColumns($columns)
            ->setHtmlAttribute('class', 'table-primary table-hover th-center')
            ->setFilters(
                \AdminDisplayFilter::scope('GetBanedUser') // ?type=news | ?latest&type=news
            );

        $display->setColumnFilters([
            AdminColumnFilter::select()
                ->setModelForOptions(\App\Models\Regions\Regions::class)
                ->setLoadOptionsQueryPreparer(function($element, $query) {
                    return $query;
                })
                ->setDisplay('name')
                ->setColumnName('torgBuyer.obl_id')
                ->setPlaceholder('Все области'),

            AdminColumnFilter::text()
                ->setColumnName('ban_email')
                ->setPlaceholder('Фильтровать по E-mail:'),

            AdminColumnFilter::text()
                ->setColumnName('ban_phone')
                ->setPlaceholder('по Тел.'),

            AdminColumnFilter::text()
                ->setColumnName('torgBuyer.name')
                ->setOperator('contains')
                ->setPlaceholder('по Имени'),

            AdminColumnFilter::text()
                ->setColumnName('torgBuyer.id')
                ->setPlaceholder('по ID'),

            AdminColumnFilter::text()
                ->setColumnName('ban_ip')
                ->setPlaceholder('по IP'),

            AdminColumnFilter::text()
                ->setColumnName('ban_ses')
                ->setPlaceholder('по SES')
                ->setHtmlAttribute('class', 'ses-search')
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

                AdminFormElement::text('torgBuyer.login', 'Логин')
                    ->required(),

                AdminFormElement::select('period_days', 'Период бана')
                    ->setOptions([
                        1 => '1 день',
                        3 => '3 дня',
                        7 => '7 дней',
                        30 => '30 дней',
                    ])->setSortable('id', true)->required(),

                AdminFormElement::text('ban_phone', 'Телефон')->required(),
                AdminFormElement::text('ban_email', 'E-mail')->required(),
                AdminFormElement::text('ban_ip', 'IP адресс')->required(),
                AdminFormElement::text('ban_ses', 'Сессия')->required(),
                AdminFormElement::text('comment', 'Комментарий')->required(),

                AdminFormElement::hidden('add_date')->setDefaultValue(Carbon::now()),

            ], 'col-xs-12 col-sm-6 col-md-5 col-lg-5')->addColumn([
                AdminFormElement::text('torgBuyer.name', 'Имя')->setReadonly(true),

                AdminFormElement::number('torgBuyer.id', 'ID пользователя')->setReadonly(true),

                AdminFormElement::text('add_date', 'Добавлено')->setReadonly(true),

                AdminFormElement::text('end_date', 'Истекает')->setReadonly(true),


            ], 'col-xs-12 col-sm-6 col-md-7 col-lg-7'),
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
        $form = AdminForm::card()->addBody([
            AdminFormElement::columns()->addColumn([

                AdminFormElement::number('user_id', 'ID пользователя')
                    ->required(),

                AdminFormElement::text('torgBuyer.login', 'Логин')
                    ->required(),

                AdminFormElement::select('period_days', 'Период бана')
                    ->setOptions([
                        1 => '1 день',
                        3 => '3 дня',
                        7 => '7 дней',
                        30 => '30 дней',
                    ])->setSortable('id', true)->required(),

                AdminFormElement::text('ban_phone', 'Телефон')->required()->setDefaultValue('не указан'),

                AdminFormElement::hidden('add_date')->setDefaultValue(Carbon::now()),

            ], 'col-xs-12 col-sm-6 col-md-5 col-lg-5')->addColumn([

                AdminFormElement::text('ban_email', 'E-mail')->required()->setDefaultValue('не указан'),

                AdminFormElement::text('ban_ip', 'IP адресс')->required()->setDefaultValue('0.0.0.0'),

                AdminFormElement::text('ban_ses', 'Сессия')->required()->setDefaultValue(rand(1, 999)),

                AdminFormElement::text('comment', 'Комментарий'),

                AdminFormElement::custom(function (Model $model){
                    $period = request()->get('period_days');
                    $model->end_date = $end_date = Carbon::now()->addDays($period)->setHour(23)->setMinute(59);
                    $model->save();
                }),

            ], 'col-xs-12 col-sm-6 col-md-7 col-lg-7'),
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
