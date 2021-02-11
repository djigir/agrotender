<?php

namespace App\Http\Sections\FastAccess;

use AdminColumn;
use AdminColumnFilter;
use AdminDisplay;
use AdminDisplayFilter;
use AdminForm;
use AdminFormElement;
use App\Models\Rayon\Rayon;
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
 * Class TorgElevator
 *
 * @property \App\Models\Elevators\TorgElevator $model
 *
 * @see https://sleepingowladmin.ru/#/ru/model_configuration_section
 */
class TorgElevator extends Section implements Initializable
{
    /**
     * @var bool
     */
    protected $checkAccess = false;

    /**
     * @var string
     */
    protected $title = 'Элеваторы';

    /**
     * @var string
     */
    protected $title_elev = '';

    /**
     * @var string
     */
    protected $alias;


    public function getEditTitle()
    {
        return "Редактировать {$this->title_elev}";
    }

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
            AdminColumn::text('id', 'ID')
                ->setWidth('50px')
                ->setHtmlAttribute('class', 'text-center')
                ->setHtmlAttributes(['style' => 'font-size: 14px']),

            AdminColumn::link('langElevator.name', 'Название')
                ->setWidth('200px')
                ->setHtmlAttributes(['class' => 'text-left', 'style' => 'font-size: 14px'])
                ->setOrderable('id'),

            AdminColumn::text('langRayon.name.', 'Район')
                ->setWidth('150px')
                ->setHtmlAttributes(['class' => 'text-left', 'style' => 'font-size: 14px'])
                ->setOrderable('obl_id'),

            AdminColumn::text('langElevator.addr', 'Адрес')
                ->setWidth('350px')
                ->setHtmlAttributes(['class' => 'text-left', 'style' => 'font-size: 14px'])
                ->setOrderable('id'),
        ];

        $display = AdminDisplay::datatables()
            ->setName('firstdatatables')
            ->setOrder([[0, 'asc']])
            ->setDisplaySearch(false)
            ->paginate(50)
            ->setColumns($columns)
            ->setFilters(
                AdminDisplayFilter::custom('obl_id')->setCallback(function ($query, $value) {
                    $query->where('obl_id', $value);
                })
            )
            ->setHtmlAttribute('class', 'table-primary table-hover th-center');

        $display->getColumnFilters()->setPlacement('card.heading');
        $display->getColumns()->getControlColumn()->setWidth('70px');
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
        $this->title_elev = $this->model_value['langElevator']['name'];
        $elevator = null;
        if ($id){
            $elevator = \App\Models\Elevators\TorgElevator::with('regionAdmin', 'langRayon')->find($id)->toArray();
        }

        $form = AdminForm::card()->addBody([
            AdminFormElement::columns()->addColumn([
                AdminFormElement::select('ray_id', 'Район области')
                    ->setModelForOptions(Rayon::class)
                    ->setLoadOptionsQueryPreparer(function($element, $query) use ($elevator, $id){
                        return $query->where('obl_id', $elevator['region_admin']['id']);
                    })->setDisplay('rayonLang.name')->required(),

                AdminFormElement::text('langElevator.name', 'Название')->required(),
                AdminFormElement::text('langElevator.orgname', 'Юридическое название')->setDefaultValue('-'),
                AdminFormElement::textarea('langElevator.addr', 'Физический адрес')->setDefaultValue('-')->setRows(7),
                AdminFormElement::textarea('langElevator.orgaddr', 'Юридический адрес')->setDefaultValue('-')->setRows(7),
                AdminFormElement::text('phone', 'Телефон')->setDefaultValue('-')->required(),
                AdminFormElement::text('email', 'E-mail')->setDefaultValue('-')->required(),
                AdminFormElement::text('langElevator.director', 'Директор')->setDefaultValue('-')->required(),
                AdminFormElement::text('langElevator.holdcond', 'Способ хранения')->required(),
                AdminFormElement::textarea('langElevator.descr_podr', 'Услуги по подработке')->setDefaultValue('-')->setRows(7)->required(),
                AdminFormElement::textarea('langElevator.descr_qual', 'Услуги по опр. качества')->setDefaultValue('-')->setRows(7)->required(),
            ], 'col-xs-12 col-sm-6 col-md-6 col-lg-3')
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
        $regions = \App\Models\Regions\Regions::get()->pluck('name', 'id');

        $form = AdminForm::card()->addBody([
            AdminFormElement::columns()->addColumn([
                AdminFormElement::select('obl_id', 'Область', $regions->toArray())->required(),
                AdminFormElement::dependentselect('ray_id', 'Район области')
                    ->setModelForOptions(Rayon::class, 'title')
                    ->setDataDepends(['obl_id'])
                    ->setLoadOptionsQueryPreparer(function($item, $query) {
                        return $query->where('obl_id', $item->getDependValue('obl_id'));
                    })
                    ->setDisplay('rayonLang.name')
                    ->setDefaultValue(0)
                    ->required(),

                AdminFormElement::text('langElevator.name', 'Название')->required(),
                AdminFormElement::text('langElevator.orgname', 'Юридическое название')->setDefaultValue('-')->setDefaultValue('-'),
                AdminFormElement::textarea('langElevator.addr', 'Физический адрес')->setDefaultValue('-')->setDefaultValue('-')->setRows(7),
                AdminFormElement::textarea('langElevator.orgaddr', 'Юридический адрес')->setDefaultValue('-')->setDefaultValue('-')->setRows(7),
                AdminFormElement::text('phone', 'Телефон')->setDefaultValue('-')->required(),
                AdminFormElement::text('email', 'E-mail')->setDefaultValue('-')->required(),
                AdminFormElement::text('langElevator.director', 'Директор')->setDefaultValue('-')->required(),
                AdminFormElement::text('langElevator.holdcond', 'Способ хранения')->setDefaultValue('-')->required(),
                AdminFormElement::textarea('langElevator.descr_podr', 'Услуги по подработке')->setDefaultValue('-')->setRows(7)->required(),
                AdminFormElement::textarea('langElevator.descr_qual', 'Услуги по опр. качества')->setDefaultValue('-')->setRows(7)->required(),
                AdminFormElement::hidden('langElevator.lang_id')->setDefaultValue(1),
            ], 'col-xs-12 col-sm-6 col-md-6 col-lg-5')->addColumn([], 'col-xs-12 col-sm-6 col-md-4 col-lg-4'),
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
