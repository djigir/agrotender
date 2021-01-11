<?php

namespace App\Http\Sections;

use AdminColumn;
use AdminColumnFilter;
use AdminDisplay;
use AdminForm;
use AdminFormElement;
use App\Models\Elevators\TorgElevatorLang;
use App\Models\Rayon\Rayon;
use App\Models\Rayon\RayonLang;
use App\Models\Regions\Regions;
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
        /* импрот Элеватора */
        $type = request()->get('type');

        if ($type == 'import_elev') {
            return AdminDisplay::datatables()->setName('firstdatatables')->setView('display.UnloadDownload.import_elevators');
        }

        $columns = [
            AdminColumn::text('id', 'id')
                ->setWidth('50px')
                ->setHtmlAttribute('class', 'text-center'),
            AdminColumn::link('langElevator.name', 'Название')
                ->setWidth('200px')
                ->setHtmlAttribute('class', 'text-left')
                ->setOrderable('id'),

            AdminColumn::text('langRayon.name.', 'Район')
                ->setWidth('100px')
                ->setHtmlAttribute('class', 'text-left')
                ->setOrderable('obl_id'),

            AdminColumn::text('langElevator.addr', 'Адрес')
                ->setWidth('300px')
                ->setHtmlAttribute('class', 'text-left')
                ->setOrderable('id'),

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
                ->setModelForOptions(\App\Models\Regions\Regions::class, 'name')
                ->setLoadOptionsQueryPreparer(function($element, $query) {
                    return $query;
                })
                ->setDisplay('name')
                ->setColumnName('obl_id')
                ->setPlaceholder('Все области'),
        ]);
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
        $elevator = null;
        if ($id){
            $elevator = \App\Models\Elevators\TorgElevator::with('region', 'langRayon')->find($id)->toArray();
        }

        $form = AdminForm::card()->addBody([
                AdminFormElement::columns()->addColumn([
                    AdminFormElement::select('ray_id', 'Район области')
                        ->setModelForOptions(Rayon::class)
                        ->setLoadOptionsQueryPreparer(function($element, $query) use ($elevator, $id){
                            return $query->where('obl_id', $elevator['region']['id']);
                        })->setDisplay('rayonLang.name')->required(),

                    AdminFormElement::text('langElevator.name', 'Название') ,
                    AdminFormElement::text('langElevator.addr', 'Юридическое название'),
                    AdminFormElement::textarea('langElevator.orgname', 'Физический адрес'),
                    AdminFormElement::textarea('langElevator.descr_qual', 'Юридический адрес'),
                    AdminFormElement::text('phone', 'Телефон'),
                    AdminFormElement::text('email', 'E-mail'),
                    AdminFormElement::text('langElevator.director', 'Директор'),
                    AdminFormElement::text('langElevator.holdcond', 'Способ хранения'),
                    AdminFormElement::textarea('langElevator.descr_podr', 'Услуги по подработке'),
                    AdminFormElement::textarea('langElevator.descr_qual', 'Услуги по опр. качества'),

//                AdminFormElement::file('filename', 'Фото (240 х 240)'),

            ], 'col-xs-12 col-sm-6 col-md-6 col-lg-6')->addColumn([
                AdminFormElement::text('id', 'ID')->setReadonly(true),
            ], 'col-xs-12 col-sm-6 col-md-4 col-lg-4'),
        ]);

        $form->getButtons()->setButtons([
            'save'  => new Save(),
            'save_and_close'  => new SaveAndClose(),
            'save_and_create'  => new SaveAndCreate(),
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
                AdminFormElement::text('langElevator.addr', 'Юридическое название')->required(),
                AdminFormElement::textarea('langElevator.orgname', 'Физический адрес')->required(),
                AdminFormElement::textarea('langElevator.descr_qual', 'Юридический адрес'),
                AdminFormElement::text('phone', 'Телефон')->required(),
                AdminFormElement::text('email', 'E-mail')->required(),
                AdminFormElement::text('langElevator.director', 'Директор')->required(),
                AdminFormElement::text('langElevator.holdcond', 'Способ хранения')->required(),
                AdminFormElement::textarea('langElevator.descr_podr', 'Услуги по подработке')->required(),
                AdminFormElement::textarea('langElevator.descr_qual', 'Услуги по опр. качества')->required(),

//                AdminFormElement::file('filename', 'Фото (240 х 240)'),

            ]),
        ]);

        $form->getButtons()->setButtons([
            'save'  => new Save(),
            'save_and_close'  => new SaveAndClose(),
            'save_and_create'  => new SaveAndCreate(),
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
