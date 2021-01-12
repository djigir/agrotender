<?php

namespace App\Http\Sections\Board;

use AdminColumn;
use AdminColumnFilter;
use AdminDisplay;
use AdminForm;
use AdminFormElement;
use App\Models\Regions\Regions;
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
use function React\Promise\all;

/**
 * Class SeoTitlesBoard
 *
 * @property \App\Models\Seo\SeoTitlesBoard $model
 *
 * @see https://sleepingowladmin.ru/#/ru/model_configuration_section
 */
class SeoTitlesBoard extends Section implements Initializable
{
    /**
     * @var bool
     */
    protected $checkAccess = false;

    /**
     * @var string
     */
    protected $title = 'Seo Titles Board';

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

            AdminColumn::text('culture.title', 'Раздел')
                ->setOrderable(function($query, $direction) {
                    $query->orderBy('cult_id', $direction);
                })
                ->setWidth('250px')
                ->setHtmlAttribute('class', 'text-center'),

            AdminColumn::custom('Область', function (Model $model) {
                $region_name = 'Все Области';

                if ($model['regions'] != null){
                    $region_name = $model['regions']->name;
                }

                return "<div class='row-text text-center'>{$region_name}</div>";
            })->setOrderable(function($query, $direction) {
                $query->orderBy('obl_id', $direction);
            })->setWidth('220px')
                ->setHtmlAttribute('class', 'text-center'),

            AdminColumn::custom('Тип', function (Model $model){
                $type = '';
                $type_id = $model->type_id;

                switch ($type_id) {
                    case 0:
                        $type = '';
                        break;
                    case 1:
                        $type = 'Куплю';
                        break;
                    case 2:
                        $type = "Продам";
                        break;
                }
                return "<div class='row-text text-center'>{$type}</div>";

            })->setOrderable(function($query, $direction) {
                $query->orderBy('type_id', $direction);
            })->setWidth('230px'),

            AdminColumn::link('page_title', 'Title')
                ->setOrderable(function($query, $direction) {
                    $query->orderBy('add_date', $direction);
                }),

        ];

        $display = AdminDisplay::datatables()
            ->setApply(function ($query){
                $query->where('pagetype', 0);
            })
            ->setName('firstdatatables')
            ->setOrder([[0, 'desc']])
            ->setDisplaySearch(false)
            ->paginate(25)
            ->setColumns($columns)
            ->setHtmlAttribute('class', 'table-primary table-hover th-center');

        $display->setColumnFilters([
            AdminColumnFilter::select()
                ->setModelForOptions(\App\Models\Regions\Regions::class, 'name')
                ->setLoadOptionsQueryPreparer(function($element, $query) {
                    return $query;
                })
                ->setDisplay('name')
                ->setColumnName('obl_id')
                ->setPlaceholder('Все области'),

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
        $regions = Regions::get()->toArray();
        $ukraine = [
            25 =>
            [ 'id' => 0, 'name' => 'Украина']
        ];
        $all_regions = array_merge($regions, $ukraine);

        $form = AdminForm::card()->addBody([
            AdminFormElement::columns()->addColumn([

                AdminFormElement::html(function (Model $model) {

                    return "<div class='form-group form-element-text'>
                        <label for='section' class='control-label required'>Раздел</label>
                    <input class='form-control' type='text' id='section' name='section' value='{$model['culture']->title}' readonly></div>";

                }),

                AdminFormElement::html(function (Model $model) use($all_regions){
                    foreach ($all_regions as $region) {
                        if ($model->obl_id == $region['id']){
                            $region_name = $region['name'];
                        }
                    }
                    return "<div class='form-group form-element-text'>
                        <label for='region' class='control-label required'>Область</label>
                    <input class='form-control' type='text' id='region' name='region' value='{$region_name}' readonly></div>";

                }),

                AdminFormElement::html(function (Model $model) use($all_regions){
                    $type = '';
                    $type_id = $model->type_id;

                    switch ($type_id) {
                        case 0:
                            $type = 'Все типы';
                            break;
                        case 1:
                            $type = 'Куплю';
                            break;
                        case 2:
                            $type = "Продам";
                            break;
                    }

                    return "<div class='form-group form-element-text'>
                        <label for='type' class='control-label required'>Тип</label>
                    <input class='form-control' type='text' id='type' name='type' value='{$type}' readonly></div>";

                }),

                AdminFormElement::textarea('page_title', 'Title')
                    ->setRows(2)
                    ->setDefaultValue('-')
                    ->required(),

                AdminFormElement::textarea('page_keywords', 'Keywords')
                    ->setRows(2)
                    ->setDefaultValue('-')
                    ->required(),

                AdminFormElement::textarea('page_descr', 'Description')
                    ->setRows(4)
                    ->setDefaultValue('-')
                    ->required(),


            ], 'col-xs-12 col-sm-6 col-md-4 col-lg-4')->addColumn([

                AdminFormElement::text('page_h1', 'Заголовок H1')
                    ->setDefaultValue('-')
                    ->required(),

                AdminFormElement::textarea('content_text', 'Текст')
                    ->setDefaultValue('-')
                        ->required(),

                AdminFormElement::textarea('content_words', 'Текст 2')->setDefaultValue('-'),

                AdminFormElement::hidden('add_date')->setDefaultValue(Carbon::now()),

                AdminFormElement::hidden('lang_id')->setDefaultValue(1),

                AdminFormElement::hidden('pagetype')->setDefaultValue(0)

            ], 'col-xs-12 col-sm-6 col-md-8 col-lg-8'),


            AdminFormElement::html('<div style="text-align: center">
                                <span>Шаблоны для объявлений категории</span><br>
                                <span>_advtit_ - обозначение заголовка объявления</span><br>
                                <span>_advcont_ - описание объявления</span><br>
                                    </div>'
                                ),

            AdminFormElement::text('tpl_items_title', 'Title')
                ->setDefaultValue('-'),

            AdminFormElement::text('tpl_items_keywords', 'Keywords')
                ->setDefaultValue('-'),

            AdminFormElement::text('tpl_items_descr', 'Description')
                ->setDefaultValue('-'),

            AdminFormElement::textarea('tpl_items_text', 'Текст')
                ->setDefaultValue('-')
                ->setRows(3),

            AdminFormElement::textarea('tpl_items_words', 'Текст2')
                ->setDefaultValue('-')
                ->setRows(3),

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
        $ukraine = [0 => 'Вся Украина'];
        $regions = Regions::pluck('name', 'id')->toArray();

        $all_regions = array_merge($ukraine, $regions);

        $form = AdminForm::card()->addBody([

            AdminFormElement::columns()->addColumn([

                AdminFormElement::select('sect_id', 'Раздел доски объявл.')
                    ->setModelForOptions(\App\Models\ADV\AdvTorgTopic::class)
                    ->setDisplay('title')
                    ->required(),


                AdminFormElement::select('obl_id', 'Область')
                    ->setOptions($all_regions)
                    ->required(),


                AdminFormElement::select('type_id', 'Тип услуги')
                    ->setOptions([
                        0 => 'Все типы',
                        1 => 'Куплю',
                        2 => 'Продам',
                    ])->required(),

                AdminFormElement::textarea('page_title', 'Title')
                    ->setRows(2)
                    ->setDefaultValue('-')
                    ->required(),

                AdminFormElement::textarea('page_keywords', 'Keywords')
                    ->setRows(2)
                    ->setDefaultValue('-')
                    ->required(),

                AdminFormElement::textarea('page_descr', 'Description')
                    ->setRows(4)
                    ->setDefaultValue('-')
                    ->required(),


            ], 'col-xs-12 col-sm-6 col-md-4 col-lg-4')->addColumn([

                AdminFormElement::text('page_h1', 'Заголовок H1')
                    ->setDefaultValue('-')
                    ->required(),

                AdminFormElement::textarea('content_text', 'Текст')
                    ->setDefaultValue('-')
                    ->required(),

                AdminFormElement::textarea('content_words', 'Текст 2')->setDefaultValue('-'),

                AdminFormElement::hidden('add_date')->setDefaultValue(Carbon::now()),

                AdminFormElement::hidden('lang_id')->setDefaultValue(1),

                AdminFormElement::hidden('pagetype')->setDefaultValue(0)

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
