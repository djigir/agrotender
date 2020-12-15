<?php

namespace App\Http\Sections\News;

use AdminColumn;
use AdminColumnFilter;
use AdminDisplay;
use AdminForm;
use AdminFormElement;
use App\Models\News\NewsComment;
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
 * Class News
 *
 * @property \App\Models\News\News $model
 *
 * @see https://sleepingowladmin.ru/#/ru/model_configuration_section
 */
class AgtNews extends Section implements Initializable
{
    /**
     * @var bool
     */
    protected $checkAccess = false;

    /**
     * @var string
     */
    protected $title = 'Новости';

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
     * @param string $title
     */
    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    /**
     * @param array $payload
     *
     * @return DisplayInterface
     */
    public function onDisplay($payload = [])
    {
        $n = \App\Models\News\News::with('NewsLang', 'NewsComment')->find(1300);
//        dd($n);

        $columns = [
            AdminColumn::text('id', 'ID')->setWidth('50px')->setHtmlAttribute('class', 'text-center'),
            AdminColumn::link('NewsLang.title', 'Содержание', 'dtime')
                ->setSearchCallback(function($column, $query, $search){
                    return $query->orWhere('NewsLang.title', 'like', '%'.$search.'%');
                })
                ->setOrderable(function($query, $direction) {
                    $query->orderBy('dtime', $direction);
                }),

            AdminColumn::boolean('first_page', 'На главную'),
            AdminColumn::count('NewsComment', 'Коммент.')
                ->setHtmlAttribute('class', 'text-center'),
            AdminColumn::boolean('intop', 'В топ')
                ->setHtmlAttribute('class', 'text-center'),
            AdminColumn::text('view_num', 'Просмотров')
                ->setHtmlAttribute('class', 'text-center')
        ];

        $display = AdminDisplay::datatables()
            ->setName('firstdatatables')
            ->setOrder([[0, 'desc']])
            ->setDisplaySearch(true)
            ->paginate(25)
            ->setColumns($columns)
            ->setHtmlAttribute('class', 'table-primary table-hover th-center');

        $display->setColumnFilters([
            AdminColumnFilter::select()
                ->setOptions([
                    0 => 'Новости Украины',
                    1 => 'Новости мира',
                    2 => 'Другие новости',
                    3 => 'Новости сайта',
                ])
                ->setLoadOptionsQueryPreparer(function($element, $query) {
                    return $query;
                })
                ->setDisplay('ngroup')
                ->setColumnName('ngroup')
                ->setPlaceholder('Группы новостей'),
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
                AdminFormElement::text('NewsLang.title', 'Заголовок')
                    ->required(),

                AdminFormElement::textarea('NewsLang.content', 'Текст'),


                AdminFormElement::select('first_page', 'На главную')
                    ->setOptions([
                        0 => 'Нет',
                        1 => 'Да',
                    ]),

                AdminFormElement::select('intop', 'В топ')
                    ->setOptions([
                        0 => 'Нет',
                        1 => 'Да',
                    ]),

//                AdminColumn::text('NewsLang.lang_id'),


                AdminFormElement::image('filename_src', 'Картинка'),



                AdminFormElement::html('<hr>'),
                AdminFormElement::datetime('dtime', 'Дата')
                    ->setVisible(true)
                    ->setReadonly(false),

            ], 'col-xs-12 col-sm-6 col-md-8 col-lg-8')->addColumn([
                AdminFormElement::text('id', 'ID')->setReadonly(true)
                    ->setHtmlAttribute('class', 'text-right'),
            ], 'col-xs-12 col-sm-6 col-md-2 col-lg-2'),
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

                AdminFormElement::select('ngroup', 'Группа новстей')
                    ->setOptions([
                        0 => 'Новости Украины',
                        1 => 'Новости мира',
                        2 => 'Другие новости',
                        3 => 'Новости сайта',
                    ])
                    ->required(),

                AdminFormElement::text('NewsLang.title', 'Заголовок')
                    ->required(),

                AdminFormElement::textarea('NewsLang.content', 'Текст'),


                AdminFormElement::select('first_page', 'На главную')
                    ->setOptions([
                        0 => 'Нет',
                        1 => 'Да',
                    ]),

//                AdminFormElement::hidden('lang_id')->defaultValue('1'),

                AdminFormElement::select('intop', 'В топ')
                    ->setOptions([
                        0 => 'Нет',
                        1 => 'Да',
                    ]),


//                AdminFormElement::image('filename_src', 'Картинка')

            ], 'col-xs-12 col-sm-9 col-md-11 col-lg-11')
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
