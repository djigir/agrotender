<?php

namespace App\Http\Sections;

use AdminColumn;
use AdminColumnFilter;
use AdminDisplay;
use AdminForm;
use AdminFormElement;
use App\Models\City\CityLang;
use App\Models\Users\UserGroups;
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
 * Class UsersAdmin
 *
 * @property \App\Models\Users\Users $model
 *
 * @see https://sleepingowladmin.ru/#/ru/model_configuration_section
 */
class UsersAdmin extends Section implements Initializable
{

    /**
     * @var bool
     */
    protected $checkAccess = false;

    /**
     * @var string
     */
    protected $title = 'Пользователи';

    /**
     * @var string
     */
    protected $alias;


    /**
     * @param string $title
     */
    public function setTitle(string $title): void
    {
        $this->title = $title;
    }


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

            AdminColumn::link('login', 'Логин')
                ->setHtmlAttributes([
                    'class' => 'fas fa-user'
                ])
                ->setWidth('100px')
                ->setHtmlAttribute('class', 'text-center'),
            AdminColumn::text('name', 'Ф.И.О')
                ->setSearchCallback(function($column, $query, $search){
                    return $query->orWhere('name', 'like', '%'.$search.'%');
                })
                ->setOrderable(function($query, $direction) {
                    $query->orderBy('login', $direction);
                })->setWidth('100px')->setHtmlAttribute('class', 'text-center')
            ,
            AdminColumn::text('address', 'Адресс')->setWidth('100px')->setHtmlAttribute('class', 'text-center'),
            AdminColumn::text('telephone', 'Телефон:')->setWidth('100px')->setHtmlAttribute('class', 'text-center'),
            AdminColumn::text('office_phone', 'Рабочий тел:')->setWidth('100px')->setHtmlAttribute('class', 'text-center'),
            AdminColumn::text('cell_phone', 'Мобильный тел:')->setWidth('100px')->setHtmlAttribute('class', 'text-center'),
        ];

        $display = AdminDisplay::datatables()
            ->setName('firstdatatables')
            ->setOrder([[0, 'asc']])
            ->setDisplaySearch(true)
            ->paginate(25)
            ->setColumns($columns)
            ->setHtmlAttribute('class', 'table-primary table-hover th-center')
        ;

        $display->setColumnFilters([
            AdminColumnFilter::select()
                ->setModelForOptions(\App\Models\Users\Users::class, 'login')
                ->setLoadOptionsQueryPreparer(function($element, $query) {
                    return $query;
                })
                ->setDisplay('login')
                ->setColumnName('id')
                ->setPlaceholder('Все пользователи')
            ,
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
                AdminFormElement::password('passwd', 'Пароль')
                    ->required()
                    ->hashWithBcrypt(),

                AdminFormElement::html('<hr>'),
                AdminFormElement::text('name', 'Ф.И.О.'),

                AdminFormElement::html('<hr>'),
                AdminFormElement::text('address', 'Адрес'),

                AdminFormElement::html('<hr>'),
                AdminFormElement::select('city_id', 'Город')
                    ->setModelForOptions(CityLang::class)
                    ->setDisplay('name'),

                AdminFormElement::html('<hr>'),
                AdminFormElement::number('zip_code', 'Почтовый Индекс'),

                AdminFormElement::html('<hr>'),
                AdminFormElement::number('telephone', 'Телефон')
                    ->setMin(10),

                AdminFormElement::html('<hr>'),
                AdminFormElement::number('office_phone', 'Рабочий тел')
                    ->setMin(10),

                AdminFormElement::html('<hr>'),
                AdminFormElement::number('cell_phone', 'Мобильный тел')
                    ->setMin(10),

                AdminFormElement::html('<hr>'),
                AdminFormElement::text('email1', 'E-Mail 1'),

                AdminFormElement::html('<hr>'),
                AdminFormElement::text('email2', 'E-Mail 2'),

                AdminFormElement::html('<hr>'),
                AdminFormElement::text('email3', 'E-Mail 3'),

                AdminFormElement::html('<hr>'),
                AdminFormElement::text('web_url', 'Веб-страница'),

                AdminFormElement::html('<hr>'),
                AdminFormElement::select('group_id', 'Группа пользователей')
                    ->setModelForOptions(UserGroups::class)
                    ->setDisplay('group_name'),
            ], 'col-xs-12 col-sm-6 col-md-4 col-lg-4')->addColumn([
                AdminFormElement::text('id', 'ID')->setReadonly(true),
            ], 'col-xs-4 col-sm-3 col-md-3 col-lg-2'),
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


                AdminFormElement::text('login', 'Логин')
                    ->required(),

                AdminFormElement::html('<hr>'),
                AdminFormElement::password('passwd', 'Пароль')
                    ->required()
                    ->hashWithBcrypt(),

                AdminFormElement::html('<hr>'),
                AdminFormElement::text('name', 'Ф.И.О.'),

                AdminFormElement::html('<hr>'),
                AdminFormElement::text('address', 'Адрес'),

                AdminFormElement::html('<hr>'),
                AdminFormElement::select('city_id', 'Город')
                    ->setModelForOptions(CityLang::class)
                    ->setDisplay('name'),

                AdminFormElement::html('<hr>'),
                AdminFormElement::number('zip_code', 'Почтовый Индекс'),

                AdminFormElement::html('<hr>'),
                AdminFormElement::number('telephone', 'Телефон')
                    ->setMin(10),

                AdminFormElement::html('<hr>'),
                AdminFormElement::number('office_phone', 'Рабочий тел')
                    ->setMin(10),

                AdminFormElement::html('<hr>'),
                AdminFormElement::number('cell_phone', 'Мобильный тел')
                    ->setMin(10),

                AdminFormElement::html('<hr>'),
                AdminFormElement::text('email1', 'E-Mail 1'),

                AdminFormElement::html('<hr>'),
                AdminFormElement::text('email2', 'E-Mail 2'),

                AdminFormElement::html('<hr>'),
                AdminFormElement::text('email3', 'E-Mail 3'),

                AdminFormElement::html('<hr>'),
                AdminFormElement::text('web_url', 'Веб-страница'),

                AdminFormElement::html('<hr>'),
                AdminFormElement::select('group_id', 'Группа пользователей')
                    ->setModelForOptions(UserGroups::class)
                    ->setDisplay('group_name'),
            ]),
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
