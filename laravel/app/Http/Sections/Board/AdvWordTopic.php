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
 * Class AdvWordTopic
 *
 * @property \App\Models\ADV\AdvWordTopic $model
 *
 * @see https://sleepingowladmin.ru/#/ru/model_configuration_section
 */
class AdvWordTopic extends Section implements Initializable
{
    /**
     * @var bool
     */
    protected $checkAccess = false;

    /**
     * @var string
     */
    protected $title = 'Подсказки к Разделам';

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
            AdminColumn::text('id', 'ID')->setHtmlAttribute('class', 'text-center')->setWidth('50px'),
            AdminColumn::text('torgTopic.title.', 'Раздел')->setOrderable(false)->setWidth('150px'),
            AdminColumn::text('keyword', 'Запрос')->setWidth('150px'),
            AdminColumn::text('add_date', 'Дата создания')->setHtmlAttribute('class', 'text-center')->setWidth('140px'),
            AdminColumn::text('rating', 'Рейтинг')->setHtmlAttribute('class', 'text-center')->setWidth('100px'),
        ];

        $display = AdminDisplay::datatables()
            ->setName('firstdatatables')
//            ->setOrder([[0, 'asc']])
            ->setDisplaySearch(false)
            ->paginate(25)
            ->setColumns($columns)
            ->setHtmlAttribute('class', 'table-primary table-hover th-center')
        ;


        $display->getColumnFilters()->setPlacement('card.heading');
        $display->getColumns()->getControlColumn()->setWidth('30px');
        return $display;
    }

//    /**
//     * @param int|null $id
//     * @param array $payload
//     *
//     * @return FormInterface
//     */
//    public function onEdit($id = null, $payload = [])
//    {
//    }

    /**
     * @return FormInterface
     */
    public function onCreate($payload = [])
    {
        $rubriks = \App\Models\ADV\AdvTorgTopic::orderBy('menu_group_id')->where('parent_id', 0)->get();
        $rubriks_gr = \App\Models\ADV\AdvTorgTgroups::get();
        $rubrik_select = [];

        foreach ($rubriks_gr as $rubrik_gr) {
            foreach ($rubriks->where('menu_group_id', '=', $rubrik_gr->id) as $rubrik) {
                $rubrik_select[$rubrik->id] = $rubrik->title . ' (' . $rubrik_gr->title . ')';
            }
        }

        $form = AdminForm::card()->addBody([
            AdminFormElement::hidden('add_date')->setDefaultValue(\Carbon\Carbon::now()),
            AdminFormElement::columns()->addColumn([
                AdminFormElement::text('keyword', 'Запрос')->required(),
                AdminFormElement::number('rating', 'Рейтинг')->setDefaultValue(0),
                AdminFormElement::select('rtopic_id', 'Раздел', $rubrik_select)->required(),
                AdminFormElement::dependentselect('topic_id', 'Секция')
                    ->setModelForOptions(\App\Models\ADV\AdvTorgTopic::class, 'title')
                    ->setDataDepends('rtopic_id')
                    ->setLoadOptionsQueryPreparer(function($item, $query) {
                        return $query->where('parent_id', $item->getDependValue('rtopic_id'));
                    })->setDisplay('title')->required(),
            ])
        ]);

        $form->getButtons()->setButtons([
            'save'  => new Save(),
            'save_and_close'  => new SaveAndClose(),
            'cancel'  => (new Cancel()),
        ]);
        //dd(\request()->all());
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
