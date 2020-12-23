<?php

namespace App\Http\Sections\FastAccess;

use AdminColumn;
use AdminColumnFilter;
use AdminDisplay;
use AdminForm;
use AdminFormElement;
use App\Models\ADV\AdvTorgTopic;
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
 * Class AdvTorgPost
 *
 * @property \App\Models\ADV\AdvTorgPost $model
 *
 * @see https://sleepingowladmin.ru/#/ru/model_configuration_section
 */
class AdvTorgPost extends Section implements Initializable
{
    /* const for Filter */
    const IN_TOP = 100;
    const COLOR_TOP = 200;


    /**
     * @var bool
     */
    protected $checkAccess = false;

    /**
     * @var string
     */
    protected $title = 'Объявления';

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
        /* products */
        $products_ids = AdvTorgTopic::pluck('id');
        $product_name = AdvTorgTopic::whereIn('parent_id', $products_ids)->get();

        /* groups */
        $topics = AdvTorgTopic::pluck('parent_id');
        $rubriks_name = AdvTorgTopic::whereIn('id', $topics)->get();

        $rubriks = [];

//        dd($product_name->where('id', 459), $rubriks_name->where('title', 'Комбайны и уборочная техника'));
        foreach ($product_name as $product) {
            foreach ($rubriks_name as $rubrick){
                if ($product->paren_id != $rubrick->id){
                    $rubriks[] = $rubrick->title;
                }
            }
        }

        $a = \App\Models\ADV\AdvTorgPost::all();

//        dd(count($rubriks), $a->count());

        $columns = [
            AdminColumn::text('id', 'ID')
                ->setWidth('100px')
                ->setHtmlAttribute('class', 'text-center'),


//            AdminColumn::custom('Тип', function (\App\Models\ADV\AdvTorgPost $torgPost){
//                return $torgPost->advertsType()->rubric_name;
//            })->setWidth('100px')->setHtmlAttribute('class', 'text-center'),
//
//            AdminColumn::text('advTorgTopic.title', 'Продукт'),

            AdminColumn::custom('Раздел', function (\Illuminate\Database\Eloquent\Model $model) use($rubriks){

                return "<div class='row-text'>
                            {$model->advertsType()->rubric_name}
                            <br>
                            {$model['advTorgTopic']->title}
                            <small class='clearfix'>{$rubriks}</small>
                        </div>";
            })->setHtmlAttribute('class', 'text-center'),


            /*AdminColumn::link('author', 'Автор/Тел.', 'phone')
                ->setHtmlAttribute('class', 'text-center')
                ->setSearchCallback(function($column, $query, $search){
                    return $query->orWhere('author', 'like', '%'.$search.'%');
                })->setOrderable(function($query, $direction) {
                    $query->orderBy('viewnum', $direction);
                }),*/


            /*AdminColumn::custom('Автор/Тел.', function (\Illuminate\Database\Eloquent\Model $model){

            }),*/


//            AdminColumn::custom('Автор/Тел.', function (\Illuminate\Database\Eloquent\Model $model){
//                dd($model['compItems']);
////                return '';
//            }),


            AdminColumn::text('torgBuyer.email', 'Email/IP', 'remote_ip')
                ->setHtmlAttribute('class', 'text-center'),


            AdminColumn::custom('Объявление', function (\Illuminate\Database\Eloquent\Model $model){
                $type_cost = $model->cost_dog;
                $currency_type = $model->cost_cur;
                $price = $model->cost;
                $product_size = $model->amount;
                $cost = '';
                $size = '';
                $currency = '';

                switch ($currency_type) {
                    case 1:
                        $currency = 'грн.';
                        break;
                    case 2:
                        $currency = '$';
                        break;
                    case 3:
                        $currency = '€';
                        break;
                }

                if ($type_cost == 0 && $price) {
                    $cost = 'Цена: ' .$model->cost. $currency;
                }

                if ($type_cost == 1 && $price) {
                    $cost = 'Цена: договорная';
                }

                if ($product_size != '' && $product_size !=0){
                    $size = 'Объем ' . $model->amount . $model->izm;
                }

                return "<div class='row-text'>
                            {$model->title}
                            <small class='clearfix'>{$cost} {$size}</small>
                        </div>";
                })->setOrderable(function($query, $direction) {
                    $query->orderBy('add_date', $direction);
                }),

            AdminColumn::text('regions.name', 'Область')
                ->setHtmlAttribute('class', 'text-center'),

            AdminColumn::text('add_date', 'Создано/Обновлено', 'up_dt')
                ->setHtmlAttribute('class', 'text-center'),

        ];

        $display = AdminDisplay::datatables()
            ->setName('firstdatatables')
            ->setOrder([[0, 'asc']])
            ->setDisplaySearch(false)
            ->paginate(25)
            ->setColumns($columns)
            ->setHtmlAttribute('class', 'table-primary table-hover th-center')
            ->setFilters(
                \AdminDisplayFilter::scope('typeAdverts') // ?type=news | ?latest&type=news
            );

        $display->setColumnFilters([
            AdminColumnFilter::select()
                ->setModelForOptions(\App\Models\Regions\Regions::class, 'name')
                ->setLoadOptionsQueryPreparer(function($element, $query) {
                    return $query;
                })
                ->setDisplay('name')
                ->setColumnName('obl_id')
                ->setPlaceholder('Все области'),

            AdminColumnFilter::select()
                ->setOptions([
                    1 =>'Куплю',
                    2 => 'Продам',
                    3 => 'Услуги'
            ])
                ->setColumnName('type_id')
                ->setPlaceholder('Все типы объявления'),

//            AdminColumnFilter::select()
//
//                ->setPlaceholder('Все разделы'),
//
//            AdminColumnFilter::select()
//
//                ->setPlaceholder('Все Секции'),
//
//            AdminColumnFilter::select()
//
//                ->setPlaceholder('За все время'),
//
//            AdminColumnFilter::select()
//
//                ->setPlaceholder('Сессия'),

            AdminColumnFilter::select()
                ->setOptions([
                    1 => 'Активные арх.',
                    0 => 'Активные не арх.',
                ])
                ->setColumnName('archive')
                ->setPlaceholder('Все актив'),

            /*\AdminColumnFilter::select()
                ->setOptions([
                    self::IN_TOP => 'Объявления в топе',
                    self::COLOR_TOP => 'Выделенные цветом',
                ])
                ->setPlaceholder('Любые объявления')->setCallback(function( $value,$query,$v) {
                    $request = \request()->get('columns')[7]['search']['value'];
                        if ($request == 100){
                            $query->where('targeting', 1);
                        }
                        if ($request == 200){
                            $query->where('colored', 1);
                        }
                }),*/

//            AdminColumnFilter::text()
//                ->setHtmlAttribute('class', 'email_search')
//                ->addStyle('my', asset('/app/assets/css/my-laravel.css'))
//                ->setColumnName('torgBuyer.email')
//                ->setPlaceholder('По Email'),
//
//            AdminColumnFilter::text()
//                ->setHtmlAttribute('class', 'phone_search')
//                ->addStyle('my', asset('/app/assets/css/my-laravel.css'))
//                ->setColumnName('phone')
//                ->setColumnName('phone2')
//                ->setPlaceholder('По Тел.'),
//
//            AdminColumnFilter::text()
//                ->setHtmlAttribute('class', 'remoteIp_search')
//                ->addStyle('my', asset('/app/assets/css/my-laravel.css'))
//                ->setColumnName('remote_ip')
//                ->setPlaceholder('По IP'),
//
//            /*AdminColumnFilter::text()
//                ->setColumnName()
//                ->setPlaceholder('SES'),*/
//
//            AdminColumnFilter::text()
//                ->setHtmlAttribute('class', 'name_search')
//                ->addStyle('my', asset('/app/assets/css/my-laravel.css'))
//                ->setColumnName('torgBuyer.name')
//                ->setOperator('contains')
//                ->setPlaceholder('По имени'),
//
            AdminColumnFilter::text()
                ->setColumnName('id')
                ->setPlaceholder('По ID'),
//
//            AdminColumnFilter::text()
//                ->setColumnName('title')
//                ->setOperator('contains')
//                ->setPlaceholder('По объявлению'),
//
//
//            AdminColumnFilter::text()
//                ->setHtmlAttribute('class', 'userId_search col-md-10')
//                ->addStyle('my', asset('/app/assets/css/my-laravel.css'))
//                ->setColumnName('torgBuyer.id')
//                ->setPlaceholder('По UserID')

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
