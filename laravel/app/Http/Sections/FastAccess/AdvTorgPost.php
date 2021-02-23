<?php

namespace App\Http\Sections\FastAccess;

use AdminColumn;
use AdminColumnFilter;
use AdminDisplay;
use AdminDisplayFilter;
use AdminForm;
use AdminFormElement;
use AdminSection;
use App\Http\Sections\Advertising\BannerPlaces;
use App\Models\ADV\AdvTorgPostModerMsg;
use App\Models\ADV\AdvTorgPostPics;
use App\Models\ADV\AdvTorgTgroups;
use App\Models\ADV\AdvTorgTopic;
use App\Models\Comp\CompTgroups;
use App\Models\Regions\Regions;
use App\Services\ImageResizeService;
use Carbon\Carbon;
use Doctrine\DBAL\Query\QueryBuilder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\URL;
use Mpdf\Tag\P;
use Mpdf\Tag\Q;
use SleepingOwl\Admin\Contracts\Display\DisplayInterface;
use SleepingOwl\Admin\Contracts\Form\FormInterface;
use SleepingOwl\Admin\Contracts\Initializable;
use SleepingOwl\Admin\Display\Display;
use SleepingOwl\Admin\Display\Element;
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
//        $this->addToNavigation()->setPriority(100)->setIcon('fa fa-lightbulb-o');
    }

    /**
     * @param array $payload
     *
     * @return DisplayInterface
     */
    public function onDisplay($payload = [])
    {
        $per_page = (int)request()->get("paginate") == 0 ? 25 : (int)request()->get("paginate");
        $columns = [
            AdminColumn::checkbox('')->setWidth('50px')->setOrderable(false),
            AdminColumn::custom('ID', function (\Illuminate\Database\Eloquent\Model $model) {
                return "<div class='row-text'>
                            <a href='https://agrotender.com.ua/board/post-{$model->getKey()}'>{$model->getKey()}</a>
                        </div>";
            })->setWidth('60px')->setOrderable(function($query, $direction) {
                    $query->orderBy('id', $direction);
            })->setHtmlAttribute('class', 'text-center'),

           AdminColumn::custom('Раздел', function (\Illuminate\Database\Eloquent\Model $model){
               $titleTopic = $model['advTorgTopic']->title??'';
               $titleSubTopic = $model->advTorgTopic->subTopic->title??'';

               return "<div class='row-text'>{$model->advertsType()->rubric_name}
                           <br>
                           {$titleTopic}
                           <small class='clearfix'>{$titleSubTopic}</small>
                       </div>";
           })->setName('city')->setWidth('160px'),


           AdminColumn::text('torgBuyer.name', 'Автор / E-mail', 'torgBuyer.email')->setWidth('190px')->setOrderable(false),

            AdminColumn::custom('Тел.', function (\Illuminate\Database\Eloquent\Model $model) {
               return "<div class='row-text'>
                           <small class='clearfix'>{$model->phone}</small>
                           <small class='clearfix'>{$model->phone2}</small>
                           <small class='clearfix'>{$model->phone3}</small>
                       </div>";
           })->setOrderable(false)->setWidth('130px')->setHtmlAttribute('class', 'text-center'),

           AdminColumn::custom('Объявление', function (\Illuminate\Database\Eloquent\Model $model){
                $type_cost = $model->cost_dog;
                $currency_type = $model->cost_cur;
                $price = $model->cost;
                $product_size = $model->amount;
                $cost = '';
                $size = '';
                $currency = '';
                $colored = '';
                $top = '';

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

                if ($model->colored) {
                    $colored ="<span style='color: #f0841b;'>Выделено цветом</span><br />";
                }
                if ($model->targeting) {
                    $top="<span style='color: #1968e0;'>Объявление в ТОП</span>";
                }

                return "<div class='row-text'>
                            {$model->title}
                            <small class='clearfix'>{$cost} {$size}</small>
                            {$colored}
                            {$top}</div>";
            })->setOrderable(function ($query, $direction) {
                $query->orderBy('add_date', $direction);
            })->setWidth('200px'),

            AdminColumn::text('regions.name', 'Область')
                ->setWidth('130px')
                ->setHtmlAttribute('class', 'text-center'),

            AdminColumn::custom('Дата созд./обн.', function (\Illuminate\Database\Eloquent\Model $model) {
                $wordsBan = '';
                $moderated = '';
                $add_date = $model->add_date->format('Y-m-d');
                if ($model->moderated == 0)
                    $wordsBan = "<span style='color: red'>попало в бан по словам</span>";
                if ($model->moderated == 1 && $model->active == 0)
                    $moderated = "<span style='color: red'>на модерации</span>";

                return "<div class='row-text'>
                            {$add_date}
                            <small class='clearfix'>{$model->up_dt}</small>
                            {$wordsBan}
                            {$moderated}</div>";
            })->setOrderable(false)->setWidth('150px')->setHtmlAttribute('class', 'text-center'),
        ];

        $display = AdminDisplay::datatables()
            ->setApply(function ($query) {
                if (!request('active'))
                    $query->where('active', 1)->where('archive', 0);

            })
            ->setName('firstdatatables')
            ->setOrder([[1, 'desc']])
            ->setDisplaySearch(false)
            ->setColumns($columns)
            ->setHtmlAttribute('class', 'table-primary table-hover th-center')
            ->setFilters(
                \AdminDisplayFilter::scope('typeAdverts'), // ?type=news | ?latest&type=news
                \AdminDisplayFilter::scope('TorgBuyerAdverts'),
                AdminDisplayFilter::custom('region')->setCallback(function ($query, $value) {
                    $query->where('obl_id', $value);
                }),
                AdminDisplayFilter::custom('ad')->setCallback(function ($query, $value) {
                    $query->where('type_id', $value);
                }),
                AdminDisplayFilter::custom('group')->setCallback(function ($query, $value) {
                    if ($value > 10000) {
                        $value = $value - 10000;
                        $query->whereHas('advTorgTopic', function ($query) use ($value) {
                            $query->where('menu_group_id', $value);
                        });
                    } else {
                        $query->whereHas('advTorgTopic', function ($query) use ($value) {
                            $query->where('parent_id', $value);
                        });
                    }
                }),
                AdminDisplayFilter::custom('active')->setCallback(function ($query, $value) {
                    if ($value == 1)//if active and !archive
                    {
                        $query->where('active', 1)->where('archive', 0);
                    } else if ($value == 2)//if active and archive
                    {
                        $query->where('active', 1)->where('archive', 1);
                    }
                }),
                AdminDisplayFilter::custom('improvements')->setCallback(function ($query, $value) {
                    if ($value == 1) {
                        $query->where('targeting', 1);
                    } else if ($value == 2) {
                        $query->where('colored', 1);
                    }
                }),
                AdminDisplayFilter::custom('email')->setCallback(function ($query, $value) {
                    $query->where('email', $value);
                }),

                AdminDisplayFilter::custom('number')->setCallback(function ($query, $value) {
                    $query->where(function ($query) use ($value) {
                        $query->where('phone', $value)->orWhere('phone2', $value)->orWhere('phone3', $value);
                    });
                }),
                AdminDisplayFilter::custom('title')->setCallback(function ($query, $value) {
                    $query->where('title', 'like', '%' . $value . '%');
                }),
                AdminDisplayFilter::custom('id')->setCallback(function ($query, $value) {
                    $query->where('id', $value);
                }),
                AdminDisplayFilter::custom('user_id')->setCallback(function ($query, $value) {
                    $query->where('author_id', $value);
                })

            );

        $display->getColumnFilters()->setPlacement('card.heading');
        $display->getColumns()->getControlColumn()->setWidth('70px');

        return $display->paginate($per_page);
    }

    /**
     * @param int|null $id
     * @param array $payload
     *
     * @return FormInterface
     */
    public function onEdit($id = null, $payload = [])
    {
        $parent_category_id = \App\Models\ADV\AdvTorgPost::find($id)->advTorgTopic->subTopic->id; //magic fix

        $form = AdminForm::card()->addBody([
            AdminFormElement::html("<div style='text-align: left'><h4>Фото в объявлении</h4></div>"),
            AdminFormElement::columns()
                ->addColumn([
                    AdminFormElement::images('images', 'Images')
                        ->setSaveCallback(function ($file, $path, $filename, $settings) use ($id) {
                            //Здесь ваша логика на сохранение картинки
                            $basePath = "/var/www/agrotender/pics/";
                            $image = new ImageResizeService($file);
                            // small image
                            $image->resizeToBestFit(140, 120);
                            $image->save($basePath . 's/' . $filename);
                            // big image
                            $image->resizeToBestFit(640, 640);
                            $image->save($basePath . 'b/' . $filename);

                            AdvTorgPostPics::create([
                                'item_id' => $id,
                                'filename' => "pics/b/$filename",
                                'filename_ico' => "pics/s/$filename",
                                'sort_num' => 2,
                                'add_date' => Carbon::now()
                            ]);
                            return ['value' => 'pics/' . 'b/' . $filename];
                    }),
                    AdminFormElement::html("<br><div style='text-align: left'><h4>Редакировать объявление</h4></div>")
                    ], 'col-xs-12 col-sm-6 col-md-8 col-lg-12')->addColumn([
                    AdminFormElement::columns()->addColumn([
                        AdminFormElement::datetime('add_date', 'Дата:')->setVisible(true)->setReadonly(false),
                    ], 'col-xs-12 col-sm-6 col-md-6 col-lg-6')->addColumn([
                        AdminFormElement::select('archive', 'Активное/Архив:')->setOptions([1 => 'В архиве', 0 => 'Активное'])->setSortable(false)->required(),
                    ], 'col-xs-12 col-sm-6 col-md-6 col-lg-6'),

                    AdminFormElement::hidden('id'),

                    AdminFormElement::text('author', 'Автор:'),
                    AdminFormElement::text('email', 'E-mail:') ->setValidationRules(['email' => 'required|email']),
                    AdminFormElement::text('phone', 'Телефон:')->setValidationRules(['phone' => 'required|min:9|numeric']),
                    AdminFormElement::columns()->addColumn([
                        AdminFormElement::select('virtual', 'Раздел:')
                            ->setModelForOptions(\App\Models\ADV\AdvTorgTopic::class)
                            ->setLoadOptionsQueryPreparer(function ($item, $query) {
                                return $query->where('parent_id', 0);
                            })->setDisplay('title')
                            ->setDefaultValue($parent_category_id),
                    ], 'col-xs-12 col-sm-6 col-md-6 col-lg-6')->addColumn([
                        AdminFormElement::dependentselect('topic_id', 'Подраздел:')
                            ->setModelForOptions(\App\Models\ADV\AdvTorgTopic::class, 'title')
                            ->setDataDepends('virtual')
                            ->setLoadOptionsQueryPreparer(function ($item, $query) {
                                return $query->where('parent_id', $item->getDependValue('virtual'));
                            })->required(),
                    ], 'col-xs-12 col-sm-6 col-md-6 col-lg-6'),
                    AdminFormElement::text('title', 'Заглавие:'),
                    AdminFormElement::textarea('content', 'Текст:')->setRows(6),
                    AdminFormElement::columns()->addColumn([
                        AdminFormElement::select('obl_id', 'Область:')->setModelForOptions(Regions::class)
                            ->setDisplay('name')->setDefaultValue(1)->required(),
                    ], 'col-xs-12 col-sm-6 col-md-6 col-lg-6')->addColumn([
                        AdminFormElement::text('city', 'Город:'),
                    ], 'col-xs-12 col-sm-6 col-md-6 col-lg-6'),
                    AdminFormElement::html("<div style='display: flex'>"),
                    AdminFormElement::text('amount', 'Объем:'),
                    AdminFormElement::text('izm', '&#160;'),
                    AdminFormElement::html("</div>"),
                    AdminFormElement::html("<div style='display: flex'>"),
                    AdminFormElement::text('cost', 'Цена:'),
                    AdminFormElement::text('cost_izm', '&#160;'),
                    AdminFormElement::html("</div>"),
                    AdminFormElement::columns()->addColumn([
                        AdminFormElement::select('colored', 'Выделение цветом:')->setOptions([1 => 'Выделено цветом', 0 => 'Обычное'])->setSortable(false)->required(),
                    ], 'col-xs-12 col-sm-6 col-md-6 col-lg-6')->addColumn([
                        AdminFormElement::select('targeting', 'Поднято в ТОП:')->setOptions([1 => 'Выделено в топе', 0 => 'Обычное'])->setSortable(false)->required(),
                    ], 'col-xs-12 col-sm-6 col-md-6 col-lg-6'),

                    AdminFormElement::hidden('ups')->setHtmlAttribute('id', 'ups'),
                    AdminFormElement::html("<button class='btn btn-default' onclick='up()'>Апнуть Объявление</button>
                                        <span >Всего:<span id='ups_count'>{$this->getModelValue()->ups}</span></span>
                                        <script> function up(){ event.preventDefault()
                                            let elem = document.getElementById(\"ups\")
                                            let value = parseInt(elem.value)+1
                                            elem.value = value
                                             document.getElementById(\"ups_count\").innerHTML = value;
                                        }</script> <br><br>"),
                    AdminFormElement::select('active', 'Статус модерации:')->setOptions([1 => 'Прошло модерацию', 0 => 'Не прошло модерацию'])->setSortable(false)->required(),

            ], 'col-xs-12 col-sm-6 col-md-4 col-lg-5')
                ->addColumn([], 'col-xs-12 col-sm-6 col-md-8 col-lg-4')
                ->addColumn([], 'col-xs-12 col-sm-6 col-md-12 col-lg-4')
        ])->addFooter([
            AdminFormElement::html("<div style='text-align: center'><a href='/admin_dev/torg_buyer_bans?GetByUserId={$this->getModelValue()->author_id}'>Перейти к управлению баном для пользователя </a></div>")
        ]);

        $form->getButtons()->setButtons([
            'save'  => (new Save()),
            'save_and_close'  => (new SaveAndClose()),
            'cancel'  => (new Cancel()),
        ]);


        $formTwo = AdminForm::card()->addBody([
            AdminFormElement::hidden('redirect')->setDefaultValue(request()->path()),
            AdminFormElement::hidden('post_id')->setDefaultValue($id),
            AdminFormElement::html("<div style='text-align: center'><h4>Сообщение о модерации</h4></div>"),
            AdminFormElement::html("<div style='display: flex;padding-top: 20px;'>"),
            AdminFormElement::checkbox('reason_1', 'Похожий заголовок&#160;&#160;&#160;')->setDefaultValue(0),
            AdminFormElement::checkbox('reason_2', 'Цена не верна&#160;&#160;&#160;')->setDefaultValue(0),
            AdminFormElement::checkbox('reason_3', 'Не цензурная брань&#160;&#160;&#160;')->setDefaultValue(0),
            AdminFormElement::checkbox('reason_4', 'Капслок')->setDefaultValue(0),
            AdminFormElement::html("</div>"),
            AdminFormElement::textarea('message', 'Текст сообщения:')->setHtmlAttribute('value', 'message')
                ->setDefaultValue("Уважаемый пользователь, Ваше объявление снято с ротации, т.к. вы нарушили следующие правила размещения объявлений:<br>
                <br>
{TPL_RULES}<br>
<br>
Исправьте данные нарушения и мы восстановим ротацию объявления."),

        ])->addFooter([
            AdminFormElement::html("<button class='btn btn-primary' >Отклонить объявление</button>")
        ]);

        $formTwo->getButtons()->setButtons([
            'save' => null,
            'save_and_close' => null,
            'cancel' => null,
        ]);

        $companies = AdminSection::getModel(AdvTorgPostModerMsg::class)->fireDisplay(['scopes' => ['test', $id]]);

        $formTwo->addBody([
            AdminFormElement::columns()->addColumn([
                $companies,
                AdminFormElement::html("<div style='text-align: center'><a href='/admin_dev/torg_buyer_bans?GetByUserId={$this->getModelValue()->author_id}'>Перейти к управлению баном для пользователя </a></div>")
            ])
        ])  ->setAction(route('savePostModerMsg'));


        $display = AdminDisplay::tabbed([
            'Редакирование' =>
                $form,
            'Модерация' => $formTwo,
        ]);

        return $display;
    }

    /**
     * @return FormInterface
     */
    /*  public function onCreate($payload = [])
      {
          return $this->onEdit(null, $payload);
      }*/

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
