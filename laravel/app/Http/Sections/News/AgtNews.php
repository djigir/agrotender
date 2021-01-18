<?php

namespace App\Http\Sections\News;

use AdminColumn;
use AdminColumnFilter;
use AdminDisplay;
use AdminForm;
use AdminFormElement;
use App\Models\News\News;
use App\Models\News\NewsComment;
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
//        $this->addToNavigation()->setPriority(100)->setIcon('fa fa-lightbulb-o');
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
        $columns = [
            AdminColumn::text('id', 'ID')
                ->setWidth('50px')
                ->setHtmlAttribute('class', 'text-center'),

            AdminColumn::link('NewsLang.title', 'Содержание', 'dtime')
                ->setSearchCallback(function($column, $query, $search){
                    return $query->orWhere('NewsLang.title', 'like', '%'.$search.'%');
                })
                ->setOrderable(function($query, $direction) {
                    $query->orderBy('dtime', $direction);
                }),

            AdminColumn::boolean('first_page', 'На главную'),


            AdminColumn::custom('Коммент.', function (Model $model) {
                $count = $model['NewsComment']->count();
                $style = 'pointer-events: none;cursor: default;color: #888;';
                if ($count != 0) {
                    $style = 'font-weight:bold';
                }
                return "<div class='row-text text-center'>
                        <a href='{$model->NewsCommentLink()}?NewsComment[item_id]={$model->getKey()}' style='{$style}' target='_blank'>{$count}</a>
                    </div>";
            }),

            AdminColumn::boolean('intop', 'В топ')
                ->setWidth('100px')
                ->setHtmlAttribute('class', 'text-center'),

            AdminColumn::text('view_num', 'Просмотров')
                ->setHtmlAttribute('class', 'text-center')
        ];

        $display = AdminDisplay::datatables()
            ->setName('firstdatatables')
            ->setOrder([[0, 'desc']])
            ->setDisplaySearch(false)
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
                ->setPlaceholder('Все группы'),

            AdminColumnFilter::text()
                ->setColumnName('NewsLang.title')
                ->setOperator('contains')
                ->setPlaceholder('По содержанию'),

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
                AdminFormElement::text('NewsLang.title', 'Заголовок')->required(),
                AdminFormElement::image('filename_src', "Картинка")
                    ->setHtmlAttribute('class', 'logo-img')
                    ->addScript('my', asset('/app/assets/my_js/admin.js'))
                    ->setSaveCallback(function ($file, $path, $filename, $settings) use ($id) {
                        $path = 'files/news/';
                        $full_path = "/var/www/agrotender/{$path}";
                        $file->move($full_path, $filename);
                        $value = $path . $filename;

                      return ['path' => asset($value), 'value' => $value = $path . $filename];
                }),
                AdminFormElement::html('<hr>'),

            ], 'col-xs-12 col-sm-6 col-md-6 col-lg-6')->addColumn([

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

                AdminFormElement::ckeditor('NewsLang.content', 'Текст'),

            ], 'col-xs-12 col-sm-6 col-md-4 col-lg-6'),
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
        $form = AdminForm::card()->addBody([
            AdminFormElement::columns()->addColumn([
                AdminFormElement::select('ngroup', 'Группа новстей')
                    ->setOptions([
                        0 => 'Новости Украины',
                        1 => 'Новости мира',
                        2 => 'Другие новости',
                        3 => 'Новости сайта',
                    ])->required(),

                AdminFormElement::text('NewsLang.title', 'Заголовок')->required(),
                AdminFormElement::select('first_page', 'На главную')
                    ->setOptions([
                        0 => 'Нет',
                        1 => 'Да',
                    ])->required(),

                AdminFormElement::hidden('NewsLang.lang_id')->setDefaultValue('1'),

                AdminFormElement::select('intop', 'В топ')
                    ->setOptions([
                        0 => 'Нет',
                        1 => 'Да',
                    ])->required(),


                AdminFormElement::image('filename_src', "Картинка")
                    ->setHtmlAttribute('class', 'logo-img')
                    ->setSaveCallback(function ($file, $path, $filename, $settings) {
                        //Здесь ваша логика на сохранение картинки
                        $path = 'files/news/';
                        $full_path = "/var/www/agrotender/{$path}";
                        $file->move($full_path, $filename);
                        $value = $path . $filename;


                        return ['path' => asset($value), 'value' => $value = $path . $filename];
                    }),


            ], 'col-xs-12 col-sm-9 col-md-6 col-lg-6')->addColumn([
                AdminFormElement::ckeditor('NewsLang.content', 'Текст'),
                AdminFormElement::hidden('dtime')->setDefaultValue(Carbon::now()),
            ], 'col-xs-12 col-sm-6 col-md-4 col-lg-6')
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
