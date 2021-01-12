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
 * Class AdvSearch
 *
 * @property \App\Models\ADV\AdvSearch $model
 *
 * @see https://sleepingowladmin.ru/#/ru/model_configuration_section
 */
class AdvSearch extends Section implements Initializable
{
    /**
     * @var bool
     */
    protected $checkAccess = false;

    /**
     * @var string
     */
    protected $title = 'Статистика запросов';

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

            AdminColumn::text('keyword', 'Запрос')
                ->setSearchCallback(function($column, $query, $search){
                    return $query->orWhere('name', 'like', '%'.$search.'%');
                })
                ->setOrderable(function($query, $direction) {
                    $query->orderBy('rating', $direction);
                }),

            AdminColumn::text('advTorgTopic.title', 'Раздел')
                ->setOrderable(function($query, $direction) {
                    $query->orderBy('topic_id', $direction);
                }),

            AdminColumn::text('add_date', 'Дата создания')
                ->setHtmlAttribute('class', 'text-center'),

            AdminColumn::text('rating', 'Рейтинг')
                ->setHtmlAttribute('class', 'text-center'),
        ];

        $display = AdminDisplay::datatables()
            ->setName('firstdatatables')
            ->setOrder([[0, 'asc']])
            ->setDisplaySearch(false)
            ->paginate(25)
            ->setColumns($columns)
            ->setHtmlAttribute('class', 'table-primary table-hover th-center');

        $display->setColumnFilters([
            AdminColumnFilter::select()
                ->setModelForOptions(\App\Models\ADV\AdvTorgTopic::class)
                ->setLoadOptionsQueryPreparer(function($element, $query) {
                    return $query;
                })
                ->setDisplay('title')
                ->setColumnName('topic_id')
                ->setPlaceholder('Все разделы')
            ,
        ]);
        $display->getColumnFilters()->setPlacement('card.heading');

        return $display;
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
