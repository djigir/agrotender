<?php

namespace App\Http\Sections\FastAccess;

use AdminColumn;
use AdminColumnFilter;
use AdminDisplay;
use AdminDisplayFilter;
use AdminForm;
use AdminFormElement;
use AdminSection;
use App\Models\ADV\AdvTorgTgroups;
use App\Models\ADV\AdvTorgTopic;
use App\Models\Comp\CompTgroups;
use App\Models\Regions\Regions;
use Carbon\Carbon;
use Doctrine\DBAL\Query\QueryBuilder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\URL;
use Mpdf\Tag\P;
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

        $columns = [

            AdminColumn::custom('ID', function (\Illuminate\Database\Eloquent\Model $model) {
                return "<div class='row-text'>
                            <a href='https://agrotender.com.ua/board/post-{$model->getKey()}'>{$model->getKey()}</a>
                        </div>";
            })->setWidth('65px')
                ->setOrderable(function($query, $direction) {
                    $query->orderBy('id', $direction);
                }),

            AdminColumn::custom('Раздел', function (\Illuminate\Database\Eloquent\Model $model){
                return "<div class='row-text'>
                            {$model->advertsType()->rubric_name}
                            <br>
                            {$model['advTorgTopic']->title}
                            <small class='clearfix'>{$model->advTorgTopic->subTopic->title}</small>
                        </div>";
            })
                ->setName('city')
                ->setHtmlAttribute('class', 'text-center'),


            AdminColumn::custom('Автор / Тел.', function (\Illuminate\Database\Eloquent\Model $model) {
                    $name = '';
                    if($model['compItems']){
                        $name = $model['compItems']->title;
                    }else {
                        $name = $model->author;
                    }


                return "<div class='row-text'>
                            {$name}
                            <small class='clearfix'>{$model->phone}</small>
                            <small class='clearfix'>{$model->phone2}</small>
                            <small class='clearfix'>{$model->phone3}</small>
                        </div>";
            })->setOrderable(function($query, $direction) {
                $query->orderBy('author_id', $direction);
            })->setWidth('130px')->setHtmlAttribute('class', 'text-center'),


            AdminColumn::custom('Email / IP /<br>Session', function (\Illuminate\Database\Eloquent\Model $model) {
                $view = '';

                if (request()->get('session') == 2) {
                    $sesIds = $model->torgBuyerSession()->pluck('ses_id');
                    foreach ($sesIds as $sesId) {
                        $view .= "<a style='font-size: 10px;'  onclick='setSesID(\"$sesId\")' href=\"#\">$sesId</a><br>";
                    }
                }

                return "<div class='row-text'>
                            {$model->email}
                            <small class='clearfix'>{$model->remote_ip}</small>
                            {$view}
                        </div>";
            }),




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
                            {$top}
                        </div>";
                })->setOrderable(function($query, $direction) {
                    $query->orderBy('add_date', $direction);
                }),

            AdminColumn::text('regions.name', 'Область')
                ->setHtmlAttribute('class', 'text-center'),


            AdminColumn::custom('Дата созд. / Дата обн.', function (\Illuminate\Database\Eloquent\Model $model) {
                $wordsBan = '';
                $moderated = '';
                if ($model->moderated == 0)
                    $wordsBan = "<span style='color: red'>попало в бан по словам</span>";
                if ($model->moderated == 1 && $model->active == 0)
                    $moderated = "<span style='color: red'>на модерации</span>";

                return "<div class='row-text'>
                            {$model->add_date}
                            <small class='clearfix'>{$model->up_dt}</small>
                            {$wordsBan}
                            {$moderated}
                          
                        </div>";
            })->setOrderable(function ($query, $direction) {
                $query->orderBy('add_date', $direction);
            }),
        ];

        $display = AdminDisplay::datatables()
            ->setApply(function ($query) {
                if (!request('active'))
                    $query->where('active', 1)->where('archive', 0);

            })
            ->setName('firstdatatables')
            ->setOrder([[0, 'asc']])
            ->setDisplaySearch(false)
            ->paginate(25)
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
                AdminDisplayFilter::custom('section')->setCallback(function ($query, $value) {
                    $query->whereHas('advTorgTopic', function ($query) use ($value) {
                        $query->where('id', $value);
                    });
                }),
                AdminDisplayFilter::custom('period')->setCallback(function ($query, $value) {
                    if ($value == 1) {
                        $query->where('add_date', '>', Carbon::today());
                    } else if ($value == 2) {
                        $query->where('add_date', '>', Carbon::today()->subDays(7));
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
                AdminDisplayFilter::custom('moderation')->setCallback(function ($query, $value) {
                    if ($value == 1) {
                        $query->where('moderated', 1)->where('active', 0);
                    } else if ($value == 2) {
                        $query->where('moderated', 1)->where('active', 1);
                    }

                }),
                AdminDisplayFilter::custom('words_ban')->setCallback(function ($query, $value) {
                    if ($value == 1) {
                        $query->where('moderated', 0);
                    } else if ($value == 2) {
                        $query->where('moderated', 1)->where('active', 1);
                    }
                }),
                AdminDisplayFilter::custom('email')->setCallback(function ($query, $value) {
                    $query->where('email', $value);
                }),
                AdminDisplayFilter::custom('number')->setCallback(function ($query, $value) {
                    $query->where(function ($query) use ($value) {
                        $query->where('phone', $value)
                            ->orWhere('phone2', $value)
                            ->orWhere('phone3', $value);
                    });

                }),
                AdminDisplayFilter::custom('session_id')->setCallback(function ($query, $value) {
                    $query->whereHas('torgBuyerSession', function ($query) use ($value) {
                        $query->where('ses_id', $value);
                    });
                }),
                AdminDisplayFilter::custom('name')->setCallback(function ($query, $value) {
                    $query->where('author', 'like', '%' . $value . '%');
                }),
                AdminDisplayFilter::custom('ip')->setCallback(function ($query, $value) {
                    $query->where('remote_ip', $value);
                }),
                AdminDisplayFilter::custom('id')->setCallback(function ($query, $value) {
                    $query->where('id', $value);
                }),
                AdminDisplayFilter::custom('text')->setCallback(function ($query, $value) {
                    $query->where('title', 'like', '%' . $value . '%');
                }),
                AdminDisplayFilter::custom('user_id')->setCallback(function ($query, $value) {
                    $query->where('author_id', $value);
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
            AdminFormElement::html("<div style='text-align: center'><h4>Редакировать объявление </h4></div>"),
            AdminFormElement::columns()->addColumn([
                AdminFormElement::datetime('add_date', 'Дата:')
                    ->setVisible(true)
                    ->setReadonly(false),

                AdminFormElement::text('author', 'Автор:'),
                AdminFormElement::text('email', 'E-mail:'),
                AdminFormElement::text('phone', 'Телефон:'),


                AdminFormElement::select('virtual', 'Секция')
                    ->setModelForOptions(\App\Models\ADV\AdvTorgTopic::class)
                    ->setLoadOptionsQueryPreparer(function ($item, $query) {
                        return $query->where('parent_id', 0);
                    })->setDisplay('title')
                    ->setDefaultValue($this->getModelValue()->advTorgTopic->subTopic->id),


                AdminFormElement::dependentselect('topic_id', 'Секция2')
                    ->setModelForOptions(\App\Models\ADV\AdvTorgTopic::class, 'title')
                    ->setDataDepends(['virtual'])
                    ->setLoadOptionsQueryPreparer(function ($item, $query) {
                        return $query->where('parent_id', $item->getDependValue('virtual'));
                    })
                    ->setDisplay('title')
                    ->required(),


                AdminFormElement::text('title', 'Заглавие:'),
                AdminFormElement::textarea('content', 'Текст:'),
            ], 'col-xs-12 col-sm-6 col-md-4 col-lg-4')
                ->addColumn([
                    /*AdminFormElement::text('id', 'ID')
                        ->setReadonly(true),*/
                    AdminFormElement::select('obl_id', 'Область:')
                        ->setModelForOptions(Regions::class)
                        ->setDisplay('name')
                        ->setDefaultValue(1)
                        ->required(),
                    AdminFormElement::text('city', 'Город:'),
                    AdminFormElement::html("<div style='display: flex'>"),
                    AdminFormElement::text('amount', 'Объем:'),
                    AdminFormElement::text('izm', '&#160;'),
                    AdminFormElement::html("</div>"),
                    AdminFormElement::html("<div style='display: flex'>"),
                    AdminFormElement::text('cost', 'Цена:'),
                    AdminFormElement::text('cost_izm', '&#160;'),
                    AdminFormElement::html("</div>"),
                    AdminFormElement::select('colored', 'Выделение цветом:')
                        ->setOptions([1 => 'Выделено цветом',
                            0 => 'Обычное'])
                        ->setSortable(false)
                        ->required(),
                    AdminFormElement::select('targeting', 'Поднято в ТОП:')
                        ->setOptions([1 => 'Выделено в топе',
                            0 => 'Обычное'])
                        ->setSortable(false)
                        ->required(),
                    AdminFormElement::hidden('ups')->setHtmlAttribute('id', 'ups'),
                    AdminFormElement::html("<button class='btn btn-default' onclick='up()'>Апнуть Объявление</button>
                                    <span >Всего:<span id='ups_count'>{$this->getModelValue()->ups}</span></span>
                                    <script> function up(){ event.preventDefault()
                                        let elem = document.getElementById(\"ups\")
                                        let value = parseInt(elem.value)+1
                                        elem.value = value
                                         document.getElementById(\"ups_count\").innerHTML = value;
                                    }</script> "),
                    AdminFormElement::select('active', 'Статус модерации:')
                        ->setOptions([1 => 'Прошло модерацию',
                            0 => 'Не прошло модерацию'])
                        ->setSortable(false)
                        ->required(),
                    AdminFormElement::select('moderated', 'Бан по словам:')
                        ->setOptions([1 => 'Все Ок, допущено',
                            0 => 'Скрыто по правилам бана'])
                        ->setSortable(false)
                        ->required(),
                    AdminFormElement::select('archive', 'Активное/Архив:')
                        ->setOptions([1 => 'В архиве',
                            0 => 'Активное'])
                        ->setSortable(false)
                        ->required(),


                ], 'col-xs-12 col-sm-6 col-md-8 col-lg-4'),
        ]);

        $form->getButtons()->setButtons([
            'save'  => new Save(),
            'save_and_close'  => new SaveAndClose(),
            'cancel'  => (new Cancel()),
        ]);


        $form2 = AdminForm::card()->addBody([
            AdminFormElement::hidden('redirect')->setDefaultValue(request()->path()),
            AdminFormElement::hidden('post_id')->setDefaultValue($this->getModelValue()->id),
            AdminFormElement::html("<div style='text-align: center'><h4>Сообщение о модерации</h4></div>"),
            AdminFormElement::html("<div style='display: flex;padding-top: 20px;'>"),
            AdminFormElement::checkbox('reason_1', 'Похожий заголовок&#160;&#160;&#160;')->setDefaultValue(0),
            AdminFormElement::checkbox('reason_2', 'Не цензурная брань&#160;&#160;&#160;')->setDefaultValue(0),
            AdminFormElement::checkbox('reason_3', 'Цена не верна&#160;&#160;&#160;')->setDefaultValue(0),
            AdminFormElement::checkbox('reason_4', 'Капслок')->setDefaultValue(0),
            AdminFormElement::html("</div>"),
            AdminFormElement::textarea('message', 'Текст сообщения:')->setHtmlAttribute('value', 'message')
                ->setDefaultValue('Уважаемый пользователь, Ваше объявление снято с ротации, т.к. вы нарушили следующие правила размещения объявлений:

{TPL_RULES}

Исправьте данные нарушения и мы восстановим ротацию объявления.'),


        ])->addFooter([
            AdminFormElement::html("<button class='btn btn-primary' >Отклонить объявление</button>")
        ])
            ->addBody([
              AdminDisplay::table()->setModelClass(\App\Models\ADV\AdvTorgPostModerMsg::class)
                ->setColumns([AdminColumn::text('id', 'Область')
                    ->setHtmlAttribute('class', 'text-center'),
                    AdminColumn::text('msg', 'Область')
                        ->setHtmlAttribute('class', 'text-center'),])
                ->setFilters(AdminDisplayFilter::custom('sdadasdasd')->setCallback(function ($query, $value) {
                })),
            ])
            ->setAction(route('savePostModerMsg'));

        $form2->getButtons()->setButtons([
            'save' => null,
            'save_and_close' => null,
            'cancel' => null,
        ]);


        $display = AdminDisplay::tabbed();
        $display->appendTab($form, 'Редакирование');
        $display->appendTab($form2, 'Модерация');

        return $display;
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
