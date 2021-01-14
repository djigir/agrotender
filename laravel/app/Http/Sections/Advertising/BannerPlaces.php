<?php

namespace App\Http\Sections\Advertising;

use AdminColumn;
use AdminColumnFilter;
use AdminDisplay;
use AdminForm;
use AdminFormElement;
use App\Models\Banner\BannerRotate;
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
 * Class BannerPlaces
 *
 * @property \App\Models\Banner\BannerPlaces $model
 *
 * @see https://sleepingowladmin.ru/#/ru/model_configuration_section
 */
class BannerPlaces extends Section implements Initializable
{
    /**
     * @var bool
     */
    protected $checkAccess = false;

    /**
     * @var string
     */
    protected $title = 'Банерные площадки';

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
            AdminColumn::text('name', 'Название типа')
                ->setWidth('50px')->setHtmlAttribute('class', 'text-center'),

            AdminColumn::custom('Размеры', function (\Illuminate\Database\Eloquent\Model $model){
                return "<div class='row-text text-center'>{$model->size_w} х {$model->size_h}</div>";
            })->setWidth('50px')->setHtmlAttribute('class', 'text-center'),

            AdminColumn::custom('Заявки/ротация', function (\Illuminate\Database\Eloquent\Model $model){
                $application = BannerRotate::where(['place_id' => $model->id, 'inrotate' => 0,'archive' => 0])->count();
                $rotation = BannerRotate::where(['place_id' => $model->id, 'inrotate' => 1, 'archive' => 0])->count();
                $route = route('admin.model', 'banner_rotates');
                return " <div class='row-link text-center'><a href={$route}?id={$model->id}' target='_blank'>{$application} / {$rotation}</a></div>";
            })->setWidth('50px')->setHtmlAttribute('class', 'text-center'),
        ];

        $display = AdminDisplay::datatables()
            ->setName('firstdatatables')
            //->setOrder([[0, 'asc']])
            ->setDisplaySearch(false)
            //->paginate(25)
            ->setColumns($columns)
            ->setHtmlAttribute('class', 'table-primary table-hover th-center')
        ;
        $display->setApply(function ($query)
        {
            $query->orderBy('id', 'desc');
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
                AdminFormElement::select('page_type', 'На какой странице', [
                    0 => 'Все страницы',
                    1 => 'Главная',
                    2 => 'Торги по регионам',
                    3 => 'Остальные страницы',
                ])->setDefaultValue(0)->required(),
                AdminFormElement::number('position', 'Номер позиции')->required(),
                AdminFormElement::text('name', 'Название места')->required(),
                AdminFormElement::select('active', 'Активная позиция', [
                    0 => 'Отключено',
                    1 => 'Активно',
                ])->setDefaultValue(1)->required(),
                AdminFormElement::number('cost_grn', 'Стоимость')->required(),
                AdminFormElement::html('Размеры банера px</br></br>'),
                AdminFormElement::number('size_w', 'ширина')->required(),
                AdminFormElement::number('size_h', 'высота')->required(),
            ], 'col-xs-12 col-sm-6 col-md-4 col-lg-6'),
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
