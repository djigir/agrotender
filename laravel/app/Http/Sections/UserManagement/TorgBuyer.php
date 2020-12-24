<?php

namespace App\Http\Sections\UserManagement;

use AdminColumn;
use AdminColumnFilter;
use AdminDisplay;
use AdminForm;
use AdminFormElement;
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
            AdminColumn::link('login', 'Логин')
                ->setSearchCallback(function($column, $query, $search){
                    return $query->orWhere('name', 'like', '%'.$search.'%');

                })
                ->setOrderable(function($query, $direction) {
                    $query->orderBy('id', $direction);
                }),

            AdminColumn::datetime('add_date', 'Дата регистрации'),

            AdminColumn::boolean('', 'Активация'),

            AdminColumn::boolean('smschecked', 'Телефон'),

            AdminColumn::text('', 'Баланс'),


            AdminColumn::text('name', 'Ф.И.О'),

            AdminColumn::text('regions.name', 'Область'),

            AdminColumn::text('phone', 'Контакты', 'email'),

            AdminColumn::text('', 'Пакеты'),

            AdminColumn::custom('Объявл.', function (\Illuminate\Database\Eloquent\Model $model) {
                return "<div class='row-text'>
                        <a href=''>{$model['advTorgPost']->count()}</a>
                    </div>";
            })->setHtmlAttribute('class', 'text-center'),

            AdminColumn::custom('Бан', function (\Illuminate\Database\Eloquent\Model $model) {
                return "<div class='row-text'>
                        <a href=''>s</a>
                    </div>";
            })->setHtmlAttribute('class', 'text-center'),

            AdminColumn::custom('Бан', function (\Illuminate\Database\Eloquent\Model $model) {
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
        ;

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

            AdminColumnFilter::text()
                ->setHtmlAttribute('class', 'count-adverts')
                ->addStyle('my', asset('/app/assets/css/my-laravel.css'))
                ->setColumnName('phone')
                ->setPlaceholder('Объявл. от'),


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
                AdminFormElement::text('name', 'Name')
                    ->required()
                ,
                AdminFormElement::html('<hr>'),
                AdminFormElement::datetime('created_at')
                    ->setVisible(true)
                    ->setReadonly(false)
                ,
                AdminFormElement::html('last AdminFormElement without comma')
            ], 'col-xs-12 col-sm-6 col-md-4 col-lg-4')->addColumn([
                AdminFormElement::text('id', 'ID')->setReadonly(true),
                AdminFormElement::html('last AdminFormElement without comma')
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
