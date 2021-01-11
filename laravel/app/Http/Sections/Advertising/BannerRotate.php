<?php

namespace App\Http\Sections\Advertising;

use AdminColumn;
use AdminColumnFilter;
use AdminDisplay;
use AdminForm;
use AdminFormElement;
use Carbon\Carbon;
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
 * Class BannerRotate
 *
 * @property \App\Models\Banner\BannerRotate $model
 *
 * @see https://sleepingowladmin.ru/#/ru/model_configuration_section
 */
class BannerRotate extends Section implements Initializable
{
    const PAGE = [
        0 => 'Все страницы',
        1 => 'Главная',
        2 => 'Торги по регионам',
        3 => 'Остальные страницы',
    ];
    /**
     * @var bool
     */
    protected $checkAccess = false;

    /**
     * @var string
     */
    protected $title = 'Ротация банеров на выбранной площадке';

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
        if(empty(\request()->all())){
            return redirect()->route('admin.model', 'banner_places');
        }

        return AdminDisplay::datatables()->setView('display.Advertising.bannerRotate');
    }

    /**
     * @param int|null $place_id
     * @param array $payload
     * @param null $type
     * @return FormInterface
     * @throws \Exception
     */
    public function onEdit($place_id = null, $payload = [], $type = null)
    {
        if($type) {
            $form = AdminForm::card()->addBody([
                AdminFormElement::columns()->addColumn([
                    AdminFormElement::text('cont_name', 'Имя заказчика')->required(),
                    AdminFormElement::hidden('place_id')->setDefaultValue($place_id),
                    AdminFormElement::hidden('add_date')->setDefaultValue(Carbon::now()),
                    AdminFormElement::text('cont_mail', 'E-mail заказчика')->required(),
                    AdminFormElement::select('pay_type', 'Способ оплаты', [
                        1 => 'Оплата наличными',
                        2 => 'Оплата на безналичный счет',
                        3 => 'Оплата через WebMoney',
                    ])->setDefaultValue(1)->required(),
                    AdminFormElement::date('dt_start_req', 'Разместить с')->required(),
                    AdminFormElement::date('dt_end_req', 'Разместить по')->required(),

                ], 'col-xs-12 col-sm-6 col-md-4 col-lg-4')
            ]);
        }
        else{
            $banner_info = \App\Models\Banner\BannerPlaces::find($this->model_value['place_id']);

            $page = self::PAGE[$banner_info->page_type];
            $position = $banner_info->position.' - '.$banner_info->name;
            $size_banner = $banner_info->size_w.' x '.$banner_info->size_h.' px';
            $period = 'с '.$this->model_value['dt_start_req']->format('Y-m-d').' по '.$this->model_value['dt_end_req']->format('Y-m-d');


            $form = AdminForm::card()->addBody([
                AdminFormElement::columns()->addColumn([
                    AdminFormElement::select('inrotate', 'В ротации', [
                        0 => 'Не ротируется',
                        1 => 'Ротируется',
                    ]),
                    AdminFormElement::date('dt_start', 'Утвержденный период с'),
                    AdminFormElement::date('dt_end', 'Утвержденный период по'),
                    AdminFormElement::image('ban_file','Картинка'),
                    AdminFormElement::text('ban_link','Url Ссылки'),
                ], 'col-xs-12 col-sm-6 col-md-4 col-lg-4')->addColumn([
                    AdminFormElement::html("
                        <div class='form-group form-element-text'>
                        <label  class='control-label'>
                            На какой странице
                        </label>
                        <input class='form-control' type='text' value='{$page}' readonly='readonly'></div>
                    "),
                    AdminFormElement::html("
                        <div class='form-group form-element-text'>
                        <label  class='control-label'>
                            На какой странице
                        </label>
                        <input class='form-control' type='text' value='{$position}' readonly='readonly'></div>
                    "),

                    AdminFormElement::html("
                        <div class='form-group form-element-text'>
                        <label  class='control-label'>
                            Размеры банера
                        </label>
                        <input class='form-control' type='text' value='{$size_banner}' readonly='readonly'></div>
                    "),
                    AdminFormElement::text('cont_name', 'Контактное лицо')->setReadonly(true),

                    AdminFormElement::html("
                        <div class='form-group form-element-text'>
                        <label  class='control-label'>
                            Желаемый период
                        </label>
                        <input class='form-control' type='text' value='{$period}' readonly='readonly'></div>
                    "),
                ], 'col-xs-12 col-sm-6 col-md-4 col-lg-6')
            ]);
        }

        $form->getButtons()->setButtons([
            'save' => new Save(),
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
        return $this->onEdit(\request()->get('place_id'), [], 'create');
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
