<?php

namespace App\Http\Sections\FastAccess;

use AdminColumn;
use AdminColumnFilter;
use AdminDisplay;
use AdminDisplayFilter;
use AdminForm;
use AdminFormElement;
use App\Models\ADV\AdvTorgTgroups;
use App\Models\ADV\AdvTorgTopic;
use App\Models\Comp\CompTgroups;
use Carbon\Carbon;
use Doctrine\DBAL\Query\QueryBuilder;
use Illuminate\Database\Eloquent\Model;
use Mpdf\Tag\P;
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

    const BY_SEVEN_DAYS = 700;
    const BY_TODAY = 999;

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


            AdminColumn::custom('Автор/Тел.', function (\Illuminate\Database\Eloquent\Model $model){
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


            AdminColumn::custom('Email/IP', function (\Illuminate\Database\Eloquent\Model $model) {
                $view = '';

                if (request()->get('session') == 2) {
                    $sesIds = $model->torgBuyerSession()->pluck('ses_id');
                    foreach ($sesIds as $sesId) {
                        $view .= "<a  onclick='setSesID(\"$sesId\")' href=\"#\">$sesId</a><br>";
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
                ->setOrderable(function($query, $direction) {
                    $query->orderBy('add_date', $direction);
                })->setHtmlAttribute('class', 'text-center'),

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

                    $query->where('moderated', $value - 1);
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
            AdminFormElement::columns()->addColumn([
                AdminFormElement::text('name', 'Name')
                    ->required(),

                AdminFormElement::html('<hr>'),
                AdminFormElement::datetime('created_at')
                    ->setVisible(true)
                    ->setReadonly(false),


//                AdminFormElement::select('id', 'Секция')
//                    ->setModelForOptions(\App\Models\ADV\AdvTorgTopic::class)
//                    ->setLoadOptionsQueryPreparer(function($item, $query) {
//                        return $query->where('parent_id', 0);
//                    })->setDisplay('title')->required(),
//
//                AdminFormElement::dependentselect('parent_id', 'Секция2')
//                    ->setModelForOptions(\App\Models\ADV\AdvTorgTopic::class, 'title')
//                    ->setDataDepends(['id'])
//                    ->setLoadOptionsQueryPreparer(function($item, $query) {
//                        return $query->where('parent_id', $item->getDependValue('id'));
//                    })
//                    ->setDisplay('title')
//                    ->required(),


                AdminFormElement::html('last AdminFormElement without comma')
            ], 'col-xs-12 col-sm-6 col-md-4 col-lg-4')->addColumn([
                AdminFormElement::text('id', 'ID')->setReadonly(true),
                AdminFormElement::html('last AdminFormElement without comma')
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
