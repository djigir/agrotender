<?php

namespace App\Http\Sections\AlgorithmManagement;

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
 * Class Preferences
 *
 * @property \App\Models\Preferences\Preferences $model
 *
 * @see https://sleepingowladmin.ru/#/ru/model_configuration_section
 */
class Preferences extends Section implements Initializable
{
    const LABELS = [
        1 => 'Курс доллара',
        2 => 'Курс евро',
        3 => 'Период обновления ленты',
        4 => 'Период жизни ленты',
        5 => 'PM_K - коєффициент для посещений',
        6 => 'C_TZU - Наличие ТЗУ',
        7 => 'C_VAC - Наличие вакансий',
        8 => 'C_NEWS - Наличие новостей',
        9 => 'C_PR - Наличие цен',
        10 => 'C_LOGO - Наличие логотипа',
        11 => 'C_DESCR - Наличие описания > 1000 знаков',
        12 => 'C_CONT - Наличие контактов для отделений',
        13 => 'Макс. кол-во предложений',
        14 => 'Макс. кол-во объявлений',
        15 => 'Публиковать объяв. без премодер',
        16 => 'Мин. сумма пополнения',
        17 => 'Время между беспл. апом',
        18 => 'Время до деактивации объявл',
    ];


    /**
     * @var bool
     */
    protected $checkAccess = false;

    /**
     * @var string
     */
    protected $title = 'Алгоритмы';

    /**
     * @var string
     */
    protected $alias;

    /**
     * Initialize class.
     */
    public function initialize()
    {
        $this->addToNavigation()->setPriority(100)->setIcon('fa fa-lightbulb-o');
    }

    /**
     * @param array $payload
     *
     * @return DisplayInterface
     */
    public function onDisplay($payload = [])
    {
        return AdminDisplay::datatables()->setName('firstdatatables')->setView('display.AlgorithmManagement.algoritmi');
    }

    /**
     * @param int|null $id
     * @param array $payload
     *
     * @return FormInterface
     */
    public function onEdit($id = null, $payload = [])
    {
        $lable = self::LABELS[$id] ?? 'Значение';
        $adminFormElement = AdminFormElement::text('value', $lable);

        if($id == 15){
            $adminFormElement = AdminFormElement::select('value', $lable, [
                0 => 'Нет, только после модерации',
                1 => 'Да, публиковать сразу на доске',
            ]);
        }

        $form = AdminForm::card()->addBody([
            AdminFormElement::columns()->addColumn([
                $adminFormElement
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
//    public function onCreate($payload = [])
//    {
//        return $this->onEdit(null, $payload);
//    }

    /**
     * @return bool
     */
//    public function isDeletable(Model $model)
//    {
//        return true;
//    }

    /**
     * @return void
     */
    public function onRestore($id)
    {
        // remove if unused
    }
}
