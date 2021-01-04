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
        $data = \App\Models\Preferences\Preferences::pluck('value', 'id');

        $columns = [
            AdminColumn::custom(self::LABELS[1], function (\Illuminate\Database\Eloquent\Model $model) use($data){
                return "<div class='row-text'>{$data[1]}</div>";
            })->setHtmlAttribute('class', 'text-center'),

            AdminColumn::custom(self::LABELS[2], function (\Illuminate\Database\Eloquent\Model $model) use($data){
                return "<div class='row-text'>{$data[2]}</div>";
            })->setHtmlAttribute('class', 'text-center'),

            AdminColumn::custom(self::LABELS[3], function (\Illuminate\Database\Eloquent\Model $model) use($data){
                return "<div class='row-text'>{$data[3]}</div>";
            })->setHtmlAttribute('class', 'text-center'),

            AdminColumn::custom(self::LABELS[4], function (\Illuminate\Database\Eloquent\Model $model) use($data){
                return "<div class='row-text'>{$data[4]}</div>";
            })->setHtmlAttribute('class', 'text-center'),

            AdminColumn::custom(self::LABELS[5], function (\Illuminate\Database\Eloquent\Model $model) use($data){
                return "<div class='row-text'>{$data[5]}</div>";
            })->setHtmlAttribute('class', 'text-center'),

            AdminColumn::custom(self::LABELS[6], function (\Illuminate\Database\Eloquent\Model $model) use($data){
                return "<div class='row-text'>{$data[6]}</div>";
            })->setHtmlAttribute('class', 'text-center'),

            AdminColumn::custom(self::LABELS[7], function (\Illuminate\Database\Eloquent\Model $model) use($data){
                return "<div class='row-text'>{$data[7]}</div>";
            })->setHtmlAttribute('class', 'text-center'),

            AdminColumn::custom(self::LABELS[8], function (\Illuminate\Database\Eloquent\Model $model) use($data){
                return "<div class='row-text'>{$data[8]}</div>";
            })->setHtmlAttribute('class', 'text-center'),

            AdminColumn::custom(self::LABELS[9], function (\Illuminate\Database\Eloquent\Model $model) use($data){
                return "<div class='row-text'>{$data[9]}</div>";
            })->setHtmlAttribute('class', 'text-center'),

            AdminColumn::custom(self::LABELS[10], function (\Illuminate\Database\Eloquent\Model $model) use($data){
                return "<div class='row-text'>{$data[10]}</div>";
            })->setHtmlAttribute('class', 'text-center'),

            AdminColumn::custom(self::LABELS[11], function (\Illuminate\Database\Eloquent\Model $model) use($data){
                return "<div class='row-text'>{$data[11]}</div>";
            })->setHtmlAttribute('class', 'text-center'),

            AdminColumn::custom(self::LABELS[12], function (\Illuminate\Database\Eloquent\Model $model) use($data){
                return "<div class='row-text'>{$data[12]}</div>";
            })->setHtmlAttribute('class', 'text-center'),

            AdminColumn::custom(self::LABELS[13], function (\Illuminate\Database\Eloquent\Model $model) use($data){
                return "<div class='row-text'>{$data[13]}</div>";
            })->setHtmlAttribute('class', 'text-center'),

            AdminColumn::custom(self::LABELS[14], function (\Illuminate\Database\Eloquent\Model $model) use($data){
                return "<div class='row-text'>{$data[14]}</div>";
            })->setHtmlAttribute('class', 'text-center'),

            AdminColumn::custom(self::LABELS[15], function (\Illuminate\Database\Eloquent\Model $model) use($data){
                return "<div class='row-text'>{$data[15]}</div>";
            })->setHtmlAttribute('class', 'text-center'),

            AdminColumn::custom(self::LABELS[16], function (\Illuminate\Database\Eloquent\Model $model) use($data){
                return "<div class='row-text'>{$data[16]}</div>";
            })->setHtmlAttribute('class', 'text-center'),

            AdminColumn::custom(self::LABELS[17], function (\Illuminate\Database\Eloquent\Model $model) use($data){
                return "<div class='row-text'>{$data[17]}</div>";
            })->setHtmlAttribute('class', 'text-center'),

            AdminColumn::custom(self::LABELS[18], function (\Illuminate\Database\Eloquent\Model $model) use($data){
                return "<div class='row-text'>{$data[18]}</div>";
            })->setHtmlAttribute('class', 'text-center'),

//            AdminColumn::custom('Время подписки на цены (дней)', function (\Illuminate\Database\Eloquent\Model $model) use($data){
//                return "<div class='row-text'></div>";
//            })->setWidth('50px')->setHtmlAttribute('class', 'text-center'),

        ];

        $display = AdminDisplay::datatables()
            ->setName('firstdatatables')
//            ->setOrder([[0, 'asc']])
//            ->setDisplaySearch(true)
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
//            'save_and_create'  => new SaveAndCreate(),
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
