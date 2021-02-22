<?php

namespace App\Http\Sections\PagesManagement;

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
 * Class Pages
 *
 * @property \App\Models\Pages\Pages $model
 *
 * @see https://sleepingowladmin.ru/#/ru/model_configuration_section
 */
class Pages extends Section implements Initializable
{
    /**
     * @var bool
     */
    protected $checkAccess = false;

    /**
     * @var string
     */
    protected $title = 'Добавить/Удалить скрипт';

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
            AdminColumn::custom('Страница', function (\Illuminate\Database\Eloquent\Model $model){
                return "<div class='row-text text-center'>{$model['pagesLang']['page_mean']} ({$model->sort_num})</div>";
            })->setWidth('180px')->setHtmlAttribute('class', 'text-center'),

            AdminColumn::text('page_name', 'Скрипт (без расшир.)')->setWidth('100px')->setOrderable(false)->setHtmlAttribute('class', 'text-center'),

            AdminColumn::custom('Ссылка', function (\Illuminate\Database\Eloquent\Model $model){
                $link_file = "";
                switch( $model->page_record_type )
                {
                    case 1:	$link_file = stripslashes($model->page_name).'.php';				break;
                    case 2:	$link_file = stripslashes($model->page_name).'/';					break;
                    case 3:	$link_file = "info.php?page=".stripslashes($model->page_name);	break;
                    case 4: $link_file = stripslashes($model->page_name);						break;
                }
                return "<div class='row-text text-center'>{$link_file}</div>";
            })->setWidth('100px')->setHtmlAttribute('class', 'text-center'),
            AdminColumn::text('create_date', 'Дата создание')->setWidth('120px')->setHtmlAttribute('class', 'text-center'),
            AdminColumn::text('modify_date', 'Дата модификации')->setWidth('120px')->setHtmlAttribute('class', 'text-center'),
        ];

        $display = AdminDisplay::datatables()
            ->setApply(function ($query)
            {
                $query->orderBy('show_in_menu')->orderBy('sort_num');
            })
            ->setName('firstdatatables')
            ->setOrder([[3, 'desc']])
            ->setDisplaySearch(false)
            ->paginate(25)
            ->setColumns($columns)
            ->setHtmlAttribute('class', 'table-primary table-hover th-center')
        ;

        $display->getColumnFilters()->setPlacement('card.heading');
        $display->getColumns()->getControlColumn()->setWidth('40px');
        return $display;
    }

    /**
     * @param int|null $id
     * @param array $payload
     *
     * @return FormInterface
     */
//    public function onEdit($id = null, $payload = [])
//    {
//        $form = AdminForm::card()->addBody([
//            AdminFormElement::columns()->addColumn([
//                AdminFormElement::text('name', 'Name')
//                    ->required()
//                ,
//                AdminFormElement::html('<hr>'),
//                AdminFormElement::datetime('created_at')
//                    ->setVisible(true)
//                    ->setReadonly(false)
//                ,
//                AdminFormElement::html('last AdminFormElement without comma')
//            ], 'col-xs-12 col-sm-6 col-md-4 col-lg-4')->addColumn([
//                AdminFormElement::text('id', 'ID')->setReadonly(true),
//                AdminFormElement::html('last AdminFormElement without comma')
//            ], 'col-xs-12 col-sm-6 col-md-8 col-lg-8'),
//        ]);
//
//        $form->getButtons()->setButtons([
//            'save'  => new Save(),
//            'save_and_close'  => new SaveAndClose(),
//            'save_and_create'  => new SaveAndCreate(),
//            'cancel'  => (new Cancel()),
//        ]);
//
//        return $form;
//    }

    /**
     * @return FormInterface
     */
    public function onCreate($payload = [])
    {
        $form = AdminForm::card()->addBody([
            AdminFormElement::columns()->addColumn([
                AdminFormElement::text('page_name', 'Имя файла (без расшир.)')->required(),
                AdminFormElement::text('pagesLang.page_mean', 'Назначение')->required(),
                AdminFormElement::text('pagesLang.page_title', 'Title'),
                AdminFormElement::text('pagesLang.page_keywords', 'Keywords'),
                AdminFormElement::textarea('pagesLang.page_descr', 'Description')->setRows(6),
                AdminFormElement::text('pagesLang.title', 'Заголовок Страницы'),
                AdminFormElement::hidden('create_date')->setDefaultValue(\Carbon\Carbon::now()),
                AdminFormElement::hidden('modify_date')->setDefaultValue(\Carbon\Carbon::now()),
                AdminFormElement::hidden('pagesLang.lang_id')->setDefaultValue(1),
                AdminFormElement::textarea('pagesLang.header', 'Верхний Контент')->setRows(6),
                AdminFormElement::textarea('pagesLang.content', 'Нижний Контент')->setRows(6),

                AdminFormElement::select('show_in_menu', 'Показывать в меню', [
                    0 => 'Нет',
                    1 => 'Верхнее меню',
                    2 => 'Меню слева',
                    3 => 'Только для зарегистрированых',
                ])->setDefaultValue(0),

                AdminFormElement::select('page_record_type', 'Тип записи страницы', [
                    0 => 'Не ссылка (заглавие подгруппы)',
                    1 => 'Обычная страница',
                    2 => 'Ссылка на подкаталог',
                    3 => 'Страница из базы',
                    4 => 'Прямая ссылка',
                ])->setDefaultValue(1),

                AdminFormElement::number('sort_num', 'Порядковый номер')->setDefaultValue(0),

            ], 'col-xs-12 col-sm-6 col-md-4 col-lg-3')->addColumn([

            ], 'col-xs-12 col-sm-6 col-md-8 col-lg-8'),
        ]);

        $form->getButtons()->setButtons([
            'save'  => new Save(),
            'save_and_close'  => new SaveAndClose(),
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
