<?php

namespace App\Http\Sections\Board;

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
 * Class AdvTorgTopic
 *
 * @property \App\Models\ADV\AdvTorgTopic $model
 *
 * @see https://sleepingowladmin.ru/#/ru/model_configuration_section
 */
class AdvTorgTopic extends Section implements Initializable
{
    /**
     * @var bool
     */
    protected $checkAccess = false;

    /**
     * @var string
     */
    protected $title = 'Разделы доски объявлений';

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
            AdminColumn::text('id', '#')->setWidth('50px')->setHtmlAttribute('class', 'text-center'),

            AdminColumn::custom('1', function (\Illuminate\Database\Eloquent\Model $model){
                $title = '';
                if(isset($model['AdvTorgTgroups'][0])){
                    $title = $model['AdvTorgTgroups'][0]['title'];
                }
                return "<div class='row-text text-center'>{$title}</div>";
            })->setWidth('150px')->setHtmlAttribute('class', 'text-center'),

            AdminColumn::custom('2', function (\Illuminate\Database\Eloquent\Model $model){
                return "<div class='row-text text-center'>{$model->title}</div>";
            })->setWidth('150px')->setHtmlAttribute('class', 'text-center'),
        ];

        $display = AdminDisplay::datatables()
            ->setName('firstdatatables')
            //->setOrder([[0, 'asc']])
            ->setDisplaySearch(false)
            ->paginate(25)
            ->setColumns($columns)
            ->setHtmlAttribute('class', 'table-primary table-hover th-center')->setView('display.Board.message_board');
        ;


        $display->getColumnFilters()->setPlacement('card.heading');

        return $display;
    }

    /**
     * @param int|null $id
     * @param int|string $type
     * @param array $payload
     *
     * @return FormInterface
     */
    public function onEdit($id = null, $payload = [], $type = '')
    {
        $groups = \App\Models\ADV\AdvTorgTgroups::orderBy('sort_num')->get();
        $section = \App\Models\ADV\AdvTorgTopic::select('parent_id', 'menu_group_id', 'id', 'sort_num', 'title')->orderBy('sort_num')->orderBy('title')->get();
        $base_section = $section->whereIn('menu_group_id', $groups->pluck('id'))->where('parent_id', 0);
        $seo_buy = [];
        $seo_sale = [];
        $seo_data = [];

        if($type != 'create'){
            $seo_data = [
                AdminFormElement::html('<span style="background-color: #c8dfec;">Seo данные</span>'),
                AdminFormElement::text('page_h1', 'H1 заголовок'),
                AdminFormElement::text('page_title','Title'),
                AdminFormElement::text('page_keywords','Keywords'),
                AdminFormElement::textarea('page_descr','Description')->setRows(5),
                AdminFormElement::textarea('descr','Описание')->setRows(5),
            ];
            $seo_buy = [
                AdminFormElement::html('<span style="background-color: #c8dfec;">Seo данные - Покупка</span>'),
                AdminFormElement::text('seo_h1_buy', 'H1 заголовок'),
                AdminFormElement::text('seo_title_buy','Title'),
                AdminFormElement::text('seo_keyw_buy','Keywords'),
                AdminFormElement::textarea('seo_descr_buy','Description')->setRows(5),
                AdminFormElement::textarea('seo_text_buy','Описание')->setRows(5),
            ];
            $seo_sale = [
                AdminFormElement::html('<span style="background-color: #c8dfec;">Seo данные - Продажа</span>'),
                AdminFormElement::text('seo_h1_sell','H1 заголовок'),
                AdminFormElement::text('seo_title_sell','Title'),
                AdminFormElement::text('seo_keyw_sell','Keywords'),
                AdminFormElement::textarea('seo_descr_sell','Description')->setRows(5),
                AdminFormElement::textarea('seo_text_sell','Описание')->setRows(5),
            ];
        }

        $form = AdminForm::card()->addBody([
            AdminFormElement::columns()->addColumn([
                AdminFormElement::select('parent_id', 'Раздел в который добавлять', $base_section->pluck('title', 'id')->toArray())->required(),
                AdminFormElement::hidden('add_date')->setDefaultValue(\Carbon\Carbon::now()),
                AdminFormElement::select('menu_group_id', 'В группе (только для 1го уровня)', $groups->pluck('title', 'id')->toArray()),
                AdminFormElement::text('title', 'Название новой рубрики')->required(),
                AdminFormElement::number('sort_num', 'Порядковый номер'),
                AdminFormElement::select('visible', 'Показывать на сайте', [
                    0 => 'Нет',
                    1 => 'Да',
                ])->setDefaultValue(1),
                AdminFormElement::textarea('descr', 'Описание'),
            ], 'col-xs-12 col-sm-6 col-md-4 col-lg-4')
            ->addColumn($seo_data, 'col-xs-12 col-sm-6 col-md-8 col-lg-8')
            ->addColumn($seo_buy, 'col-xs-12 col-sm-6 col-md-8 col-lg-6')
            ->addColumn($seo_sale, 'col-xs-12 col-sm-6 col-md-8 col-lg-6')
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
        return $this->onEdit(null, $payload, 'create');
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
