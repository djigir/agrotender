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
use SleepingOwl\Admin\Facades\Admin;
use SleepingOwl\Admin\Form\Buttons\Cancel;
use SleepingOwl\Admin\Form\Buttons\Save;
use SleepingOwl\Admin\Form\Buttons\SaveAndClose;
use SleepingOwl\Admin\Form\Buttons\SaveAndCreate;
use SleepingOwl\Admin\Section;

/**
 * Class AdvTorgPostComplains
 *
 * @property \App\Models\ADV\AdvTorgPostComplains $model
 *
 * @see https://sleepingowladmin.ru/#/ru/model_configuration_section
 */
class AdvTorgPostComplains extends Section implements Initializable
{
    /**
     * @var bool
     */
    protected $checkAccess = false;

    /**
     * @var string
     */
    protected $title = 'Жалобы на Объявления';

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
            AdminColumn::checkbox('')->setOrderable(false)->setWidth('50px'),
            AdminColumn::link('id', 'ID')->setWidth('70px')->setHtmlAttribute('class', 'text-center')->setSearchable(false),

            AdminColumn::custom('Автор/Дата регистр.', function (\Illuminate\Database\Eloquent\Model $model) {
                $author = 'Аноним';
                if ($model['torgBuyer']){
                    $author = $model['torgBuyer']->name;
                }
                return "<div class='row-text'>
                            {$author}
                            <small class='clearfix'>{$model->add_date}</small>
                        </div>";
            })->setWidth('180px'),

            AdminColumn::custom('Жалоба', function (\Illuminate\Database\Eloquent\Model $model) {
                $text = \Illuminate\Support\Str::limit(mb_convert_encoding($model->msg, 'utf-8'), 50, $end='...');
                return "<div class='row-text'>{$text}</div>";
            })->setWidth('250px'),

            AdminColumn::boolean('status', 'Новое')->setWidth('50px')->setHtmlAttribute('class', 'text-center'),

            AdminColumn::custom('Объявление', function (\Illuminate\Database\Eloquent\Model $model){
                $advert = 'Объявление не найдено';
                if ($model['advTorgPostComplains']){
                    $advert = $model['advTorgPostComplains']->title;
                }
                return "<div class='row-text'>
                            <a href='{$model->adv_url}'>{$advert}</a>
                        </div>";
            })->setWidth('150px')->setHtmlAttribute('class', 'text-center')->setSearchable(true)
                ->setSearchCallback(function($column, $query, $search){
                    $query->whereHas('advTorgPostComplains', function ($lang) use ($search) {
                        $lang->where('title', 'like', '%' . $search . '%');
                    });
            }),
        ];

        $display = AdminDisplay::datatables()
            ->setName('firstdatatables')
            ->setOrder([[1, 'asc']])
            ->setDisplaySearch(true)
            ->paginate(25)
            ->setColumns($columns)
            ->setHtmlAttribute('class', 'table-primary table-hover th-center');

        $display->setColumnFilters([
            AdminColumnFilter::text()
                ->setColumnName('msg')
                ->setOperator('contains')
                ->setPlaceholder('По жалобе'),

            AdminColumnFilter::text()
                ->setColumnName('id')
                ->setOperator('contains')
                ->setPlaceholder('по ID')
        ]);

        $display->getColumnFilters()->setPlacement('card.heading');
        $display->getColumns()->getControlColumn()->setWidth('40px');

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

                AdminFormElement::select('viewed', 'Просмотрено')
                    ->setOptions([
                        0 => 'Нет',
                        1 => 'Да',
                    ]),

                AdminFormElement::select('status', 'Статус')
                    ->setOptions([
                        0 => 'Новый',
                        1 => 'Обработаный'
                    ]),


            ], 'col-xs-12 col-sm-6 col-md-4 col-lg-4')->addColumn([

                AdminFormElement::ckeditor('msg', 'Текст')
                    ->required(),

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
