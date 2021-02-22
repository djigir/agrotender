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
 * Class FaqGroup
 *
 * @property \App\Models\Faq\FaqGroup $model
 *
 * @see https://sleepingowladmin.ru/#/ru/model_configuration_section
 */
class FaqGroup extends Section implements Initializable
{
    /**
     * @var bool
     */
    protected $checkAccess = false;

    /**
     * @var string
     */
    protected $title = 'Разделы библиотеки';

    /**
     * @var string
     */
    protected $alias;

    /**
     * Initialize class.
     */
    public function initialize()
    {
        //$this->addToNavigation()->setPriority(100)->setIcon('fa fa-lightbulb-o');
    }

    /**
     * @param array $payload
     *
     * @return DisplayInterface
     */
    public function onDisplay($payload = [])
    {
        $columns = [
            AdminColumn::custom('Иконка', function (Model $model) {
                $url = \Str::before(\Request::url(), '/ad') . '/files/' . $model->icon_filename;
                return "<div class='row-image logo-img'>
						<a href='{$url}' data-toggle='lightbox'>
				            <img width='50' height='50' class='thumbnail' src='{$url}'>
			            </a>
			            </div>";
            })->setWidth('200px')->setOrderable(false),

            AdminColumn::custom('Название', function (Model $model) {
                return "<div class='row-text text-center'>{$model['FaqGroupLang']['type_name']}</div>";
            })->setWidth('200px'),

            AdminColumn::custom('Описание', function (Model $model) {
                return "<div class='row-text text-center'>{$model['FaqGroupLang']['descr']}</div>";
            })->setWidth('200px'),
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
                AdminFormElement::text('FaqGroupLang.type_name', 'Название группы')->required(),
                AdminFormElement::image('icon_filename', 'Иконка')
                    ->setHtmlAttribute('class', 'logo-img')
                    ->addScript('my', asset('/app/assets/my_js/admin.js'))
                    ->setSaveCallback(function ($file, $path, $filename, $settings) {
                        $path = 'faqgr_ico/';
                        $full_path = "/var/www/agrotender/{$path}";
                        $file->move($full_path, $filename);
                        $value = $path . $filename;
                        return ['path' => asset($value), 'value' => $value = $path . $filename];
                    }),
                AdminFormElement::text('url', 'URL')->required(),
                AdminFormElement::number('sort_num', 'Порядковый номер')->required(),
                AdminFormElement::textarea('FaqGroupLang.descr', 'Описание группы'),

            ], 'col-xs-12 col-sm-6 col-md-4 col-lg-3')->addColumn([

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
