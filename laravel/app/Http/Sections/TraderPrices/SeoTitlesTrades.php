<?php

namespace App\Http\Sections\TraderPrices;

use AdminColumn;
use AdminColumnFilter;
use AdminDisplay;
use AdminDisplayFilter;
use AdminForm;
use AdminFormElement;
use App\Models\ADV\AdvTorgTopic;
use App\Models\Regions\Regions;
use App\Models\Traders\Traders_Products_Lang;
use App\Models\Traders\TradersProductGroupLanguage;
use App\Models\Traders\TradersProductGroups;
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
 * Class SeoTitlesTrades
 *
 * @property \App\Models\Seo\SeoTitles $model
 *
 * @see https://sleepingowladmin.ru/#/ru/model_configuration_section
 */
class SeoTitlesTrades extends Section implements Initializable
{
    /**
     * @var bool
     */
    protected $checkAccess = false;

    /**
     * @var string
     */
    protected $title = 'Seo Titles Traders';

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
                ->setWidth('50px')
                ->setHtmlAttribute('class', 'text-center'),

            AdminColumn::text('tradersProductsLang.name', 'Культура')
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
                        $type = 'Закупки';
                        break;
                    case 1:
                        $type = 'Продажи';
                        break;
                    case 3:
                        $type = "Форварды";
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
                $query->where('pagetype', 2);
            })
            ->setName('firstdatatables')
            ->setOrder([[0, 'desc']])
            ->setDisplaySearch(false)
            ->paginate(25)
            ->setColumns($columns)
            ->setHtmlAttribute('class', 'table-primary table-hover th-center')
            ->setFilters(
                AdminDisplayFilter::custom('obl_id')->setCallback(function ($query, $value) {
                    $query->where('obl_id', $value);
                })
            );

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

                AdminFormElement::text('tradersProductsLang.name', 'Раздел')->setReadonly(true),

                AdminColumn::custom('Область', function (Model $model){
                    $region_name = 'Украина';

                    if ($model['regions'] != null){
                        $region_name = $model['regions']->name;
                    }
                    return "<label for='tradersProductsLang[name]' class='control-label'>Область</label>

                    <input class='form-control' type='text' id='regions__name'
                    name='regions[name]' value='{$region_name}' readonly='readonly'>";
                }),

                AdminColumn::custom('Тип', function (Model $model){
                    $type = '';
                    $type_id = $model->type_id;

                    switch ($type_id) {
                        case 0:
                            $type = 'Закупки';
                            break;
                        case 1:
                            $type = 'Продажи';
                            break;
                        case 3:
                            $type = "Форварды";
                            break;
                    }
                    return "<label for='tradersProductsLang[name]' class='control-label' style='margin-top: 7px;'>Тип</label>

                        <input class='form-control' type='text' id='type_seo_title'
                    name='type_seo_title[type_id]' value='{$type}' readonly='readonly' style='margin-bottom: 10px'>";
                }),

                AdminFormElement::ckeditor('page_title', 'Title')
                    ->required(),

                AdminFormElement::ckeditor('page_descr', 'Description')
                    ->required(),

                AdminFormElement::text('page_h1', 'Заголовок H1'),


            ], 'col-xs-12 col-sm-6 col-md-5 col-lg-5')->addColumn([

                AdminFormElement::ckeditor('content_text', 'Текст'),

                AdminFormElement::ckeditor('content_words', 'Текст 2'),

                AdminFormElement::hidden('add_date')->setDefaultValue(Carbon::now()),

            ], 'col-xs-12 col-sm-6 col-md-7 col-lg-7'),
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
//        $type = \request()->get('type');
//
//        if ($type == 'seo_board'){
//            $regions = Regions::pluck('id', 'name')->toArray();
//            $ukraine = ['Вся Украина' => 0];
//            $all_regions = array_merge($regions, $ukraine);
//            $all_regions = array_flip($all_regions);
//
//            /* вывод с главной категорией */
//
//            $rubriks = \App\Models\ADV\AdvTorgTopic::where('parent_id', '!=', 0)->get();
//
//            $rubriks_gr = AdvTorgTopic::where('parent_id', 0)->get();
//
//            $rubriks_gr_name = AdvTorgTopic::where('parent_id', 0)->pluck('title', 'id')->toArray();
//
//            $rubrik_select = [];
//
//            foreach ($rubriks_gr as $rubrick_gr) {
//                foreach ($rubriks as $rubrik) {
//                    if ($rubrik->parent_id !== $rubrick_gr->id) {
//                        continue;
//                    }
//                    $rubrik_select[$rubrik->id] = $rubrik->title . ' (' . $rubrick_gr->title . ')';
//                }
//            }
//
//
//            $form = AdminForm::card()->addBody([
//                AdminFormElement::columns()->addColumn([
//
//
//                    AdminFormElement::select('sect_id', 'Раздел')
//                        ->setOptions($rubriks_gr_name)->setSortable('menu_group_id'),
//
//                    AdminFormElement::select('sect_id', 'Раздел с культурой')
//                        ->setOptions($rubrik_select)->setSortable('menu_group_id'),
//
//
//                    AdminFormElement::select('obl_id', 'Область')
//                        ->setOptions($all_regions)
//                        ->setDisplay($all_regions)
//                        ->setDefaultValue(0),
//
//                    AdminFormElement::select('type_id', 'Тип')
//                        ->setOptions([
//                            0 => 'Все типы',
//                            1 => 'Куплю',
//                            2 => 'Продам',
//                        ])->setDefaultValue(0)->required(),
//
//
//                    AdminFormElement::textarea('page_title', 'Title')
//                        ->setRows(3)
//                        ->required(),
//
//                    AdminFormElement::textarea('page_descr', 'Description')
//                        ->setRows(4)
//                        ->required(),
//
//                    AdminFormElement::text('page_h1', 'Заголовок H1')
//                        ->required(),
//
//
//                ], 'col-xs-12 col-sm-6 col-md-5 col-lg-5')->addColumn([
//
//                    AdminFormElement::textarea('content_text', 'Текст')
//                        ->required(),
//
//                    AdminFormElement::textarea('content_words', 'Текст 2')->setDefaultValue('-'),
//
//                    AdminFormElement::hidden('add_date')->setDefaultValue(Carbon::now()),
//
//                    AdminFormElement::hidden('lang_id')->setDefaultValue(1),
//
//                    AdminFormElement::hidden('pagetype')->setDefaultValue(0)
//
//                ], 'col-xs-12 col-sm-6 col-md-7 col-lg-7'),
//            ]);
//
//            $form->getButtons()->setButtons([
//                'save'  => new Save(),
//                'save_and_close'  => new SaveAndClose(),
//                'save_and_create'  => new SaveAndCreate(),
//                'cancel'  => (new Cancel()),
//            ]);
//
//            return $form;
//        }


        $regions = Regions::pluck('id', 'name')->toArray();
        $ukraine = ['Вся Украина' => 0];
        $all_regions = array_merge($regions, $ukraine);
        $all_regions = array_flip($all_regions);

        /* вывод с главной категорией */

        $rubriks = \App\Models\Traders\TradersProducts::orderBy('group_id')->where('acttype', 0)->get();

        $rubriks_gr = TradersProductGroupLanguage::all();

        $rubrik_select = [];

        foreach ($rubriks_gr as $rubrick_gr) {
            foreach ($rubriks as $rubrik) {
                if ($rubrik->group_id !== $rubrick_gr->id) {
                    continue;
                }
                $rubrik_select[$rubrik->id] = $rubrik['tradersProductLang']->name . ' (' . $rubrick_gr->name . ')';
            }
        }


        $form = AdminForm::card()->addBody([
            AdminFormElement::columns()->addColumn([


                AdminFormElement::select('cult_id', 'Раздел')
                    ->setOptions($rubrik_select)->setSortable('group_id')
                    ->required(),


                AdminFormElement::select('obl_id', 'Область')
                    ->setOptions($all_regions)
                    ->setDisplay($all_regions)
                    ->setDefaultValue(0),

                AdminFormElement::select('type_id', 'Тип')
                    ->setOptions([
                        0 => 'Закупки',
                        1 => 'Продажи',
                        3 => 'Форварды',
                    ])->required(),


                AdminFormElement::ckeditor('page_title', 'Title')
                    ->required(),

                AdminFormElement::ckeditor('page_descr', 'Description')
                    ->required(),

                AdminFormElement::text('page_h1', 'Заголовок H1')
                    ->required(),


            ], 'col-xs-12 col-sm-6 col-md-5 col-lg-5')->addColumn([

                AdminFormElement::ckeditor('content_text', 'Текст')
                    ->required(),

                AdminFormElement::ckeditor('content_words', 'Текст 2')->setDefaultValue('-'),

                AdminFormElement::hidden('add_date')->setDefaultValue(Carbon::now()),

                AdminFormElement::hidden('lang_id')->setDefaultValue(1),

                AdminFormElement::hidden('pagetype')->setDefaultValue(2)

            ], 'col-xs-12 col-sm-6 col-md-7 col-lg-7'),
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
