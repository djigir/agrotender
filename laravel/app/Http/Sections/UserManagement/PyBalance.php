<?php

namespace App\Http\Sections\UserManagement;

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
 * Class PyBalance
 *
 * @property \App\Models\Py\PyBalance $model
 *
 * @see https://sleepingowladmin.ru/#/ru/model_configuration_section
 */
class PyBalance extends Section implements Initializable
{
    /**
     * @var bool
     */
    protected $checkAccess = false;

    /**
     * @var string
     */
    protected $title = 'Операции по счету пользователей';

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
//        {$model['pyBill']['torgBuyer']['login']}
        $columns = [
            AdminColumn::datetime('add_date', 'Дата')->setFormat('Y-m-d H:i:s')->setOrderable(false),
            AdminColumn::text('torgBuyer.login', 'Логин')->setOrderable(false),
            AdminColumn::text('torgBuyer.name', 'Пользователь')->setOrderable(false),
            AdminColumn::custom('Кто провел', function (\Illuminate\Database\Eloquent\Model $model) {
                $spent = $model->oper_by == 1 ? 'Админ' : 'Польз.';

                return "<div class='row-text'>{$spent}</div>";
            }),

            AdminColumn::custom('Тип платежа', function (\Illuminate\Database\Eloquent\Model $model) {
                $payment_type = $model->oper_debkred == 1 ? 'Пополнение' : 'Списание';

                return "<div class='row-text'>{$payment_type}</div>";
            }),

            AdminColumn::custom('Назначение', function (\Illuminate\Database\Eloquent\Model $model) {
                $appointment = null;

                if($model->oper_debkred == 1){
                    $appointment = "Пополнение счета";
                    switch( $model->kredit_type )
                    {
                        case 1:	$appointment .= " - Приват24";	break;
                        case 2:	$appointment .= " - Картой";	break;
                        case 3:	$appointment .= " - По счету";	break;
                    }
                } else{
                    if(isset($model['buyerTarifPacks'][0]) && $model['buyerTarifPacks'][0]['id'] != 0){
                        $appointment = 'Оплата за - '.$model['buyerTarifPacks'][0]->title;
                    }
                }

                return "<div class='row-text'>{$appointment}</div>";
            }),

            AdminColumn::text('amount', 'Сумма')->setWidth('70px')->setHtmlAttribute('class', 'text-center')->setOrderable(false),

            AdminColumn::custom('Счет', function (\Illuminate\Database\Eloquent\Model $model) {
                $score = $model->bill_id != 0 ? $model->bill_id : ' - ';

                return "<div class='row-text'>{$score}</div>";
            })->setHtmlAttribute('class', 'text-center'),
        ];


        $display = AdminDisplay::datatables()
            ->setName('firstdatatables')
//            ->setOrder([[0, 'asc']])
//            ->setDisplaySearch(true)
            ->paginate(25)
            ->setColumns($columns)
            ->setHtmlAttribute('class', 'table-primary table-hover th-center');

        $display->setApply(function ($query)
        {
            $query->orderBy('add_date', 'desc');
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
//    public function onEdit($id = null, $payload = [])
//    {
//        $form = AdminForm::card()->addBody([
//            AdminFormElement::columns()->addColumn([
//                AdminFormElement::text('name', 'Name')
//                    ->required()
//                ,
//                AdminFormElement::html('<hr>'),
//                AdminFormElement::datetime('created_at')
//                    ->setVisible(true)
//                    ->setReadonly(false)
//                ,
//                AdminFormElement::html('last AdminFormElement without comma')
//            ], 'col-xs-12 col-sm-6 col-md-4 col-lg-4')->addColumn([
//                AdminFormElement::text('id', 'ID')->setReadonly(true),
//                AdminFormElement::html('last AdminFormElement without comma')
//            ], 'col-xs-12 col-sm-6 col-md-8 col-lg-8'),
//        ]);
//
//        $form->getButtons()->setButtons([
//            'save'  => new Save(),
//            'save_and_close'  => new SaveAndClose(),
//            'save_and_create'  => new SaveAndCreate(),
//            'cancel'  => (new Cancel()),
//        ]);
//
//        return $form;
//    }

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
