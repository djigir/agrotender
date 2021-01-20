<?php

namespace App\Http\Sections\News;

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
 * Class Faq
 *
 * @property \App\Models\Faq\Faq $model
 *
 * @see https://sleepingowladmin.ru/#/ru/model_configuration_section
 */
class Faq extends Section implements Initializable
{
    /**
     * @var bool
     */
    protected $checkAccess = false;

    /**
     * @var string
     */
    protected $title = 'Статьи';

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
            AdminColumn::custom('Содержание faq', function (Model $model) {
                return "<div class='row-text text-center'>{$model['FaqLang']['title']} ({$model->sort_num})</div>";
            })->setWidth('150px'),
            AdminColumn::text('FaqGroup.FaqGroupLang.type_name', 'Группа')->setWidth('50px')->setHtmlAttribute('class', 'text-center'),
            AdminColumn::text('filename', 'Прикрепленный Файл')->setWidth('50px')->setHtmlAttribute('class', 'text-center'),
            AdminColumn::text('view_num', 'Просм.')->setWidth('50px')->setHtmlAttribute('class', 'text-center'),
        ];

        $display = AdminDisplay::datatables()
            ->setName('firstdatatables')
            //->setOrder([[0, 'asc']])
            ->setDisplaySearch(false)
            ->paginate(25)
            ->setColumns($columns)
            ->setHtmlAttribute('class', 'table-primary table-hover th-center')
        ;

        $display->setColumnFilters([
            AdminColumnFilter::select()
                ->setModelForOptions(\App\Models\Faq\FaqGroup::class, 'FaqGroupLang.type_name')
                ->setLoadOptionsQueryPreparer(function($element, $query) {return $query;})
                ->setDisplay('FaqGroupLang.type_name')
                ->setColumnName('group_id')
                ->setPlaceholder('Все группы'),
        ]);

        $display->setApply(function ($query)
        {
            $query->orderBy('group_id');
        });

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
                AdminFormElement::hidden('FaqLang.item_id')->setDefaultValue($this->model_value['id']),
                AdminFormElement::hidden('add_date')->setDefaultValue(\Carbon\Carbon::now()),
                AdminFormElement::select('group_id', 'Группа')->setModelForOptions(\App\Models\Faq\FaqGroup::class, 'FaqGroupLang.type_name')->required(),
                AdminFormElement::text('FaqLang.title', 'Вопрос')->required(),
                AdminFormElement::file('filename', 'Файл (*.pdf, *.doc, *.zip)')
                    ->setValidationRules(['filename' => 'mimes:pdf,doc,zip'])
                    ->setSaveCallback(function ($file, $path, $filename, $settings){
                        $path = 'files/articles/';
                        $full_path = "/var/www/agrotender/{$path}";
                        $file->move($full_path, $filename);
                        $value = $path . $filename;
                        return ['path' => asset($value), 'value' => $value];
                    }),
                AdminFormElement::number('sort_num', 'Порядковый номер')->setDefaultValue(0)->required(),
            ], 'col-xs-12 col-sm-6 col-md-4 col-lg-5')->addColumn([
                AdminFormElement::ckeditor('FaqLang.content', 'Ответ')->setReadonly(true),
            ], 'col-xs-12 col-sm-6 col-md-8 col-lg-7'),
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
