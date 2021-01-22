<?php

namespace App\Http\Sections\FastAccess;

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
 * Class ModerMsg
 *
 * @property \App\Models\ADV\AdvTorgPostModerMsg.php $model
 *
 * @see https://sleepingowladmin.ru/#/ru/model_configuration_section
 */
class ModerMsg extends Section implements Initializable
{
    /**
     * @var bool
     */
    protected $checkAccess = false;

    /**
     * @var string
     */
    protected $title = 'Сообщения модерации';

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
            AdminColumn::text('id', 'ID')
                ->setHtmlAttribute('class', 'text-center')->setWidth('80px'),
            AdminColumn::text('add_date', 'Дата')
                ->setHtmlAttribute('class', 'text-center')->setWidth('110px'),
            AdminColumn::custom('Текст', function (\Illuminate\Database\Eloquent\Model $model) {
                return "<div class='row-text'>
                            {$model->msg}
                            </div>";
            }),
            AdminColumn::custom('Исправлено', function (\Illuminate\Database\Eloquent\Model $model) {
                $text = $model->fixed ? "<span style='color: red'>Да</span>" : '-';
                return "<div class='row-text'>
                            {$text}
                            </div>";
            }),
            AdminColumn::text('fix_date', 'Дата испр.')
                ->setHtmlAttribute('class', 'text-center')->setWidth('110px'),
        ];


        $display = AdminDisplay::datatables()
            ->setName('firstdatatables')
            ->setApply(function ($query){
                $url = parse_url(request()->headers->get('referer'));
                $id = explode("/", $url['path'])[3];
                $query->where('post_id',$id);
            })
            ->setOrder([[0, 'asc']])
            ->setDisplaySearch(false)
            ->paginate(25)
            ->setColumns($columns)
            ->setHtmlAttribute('class', 'table-primary table-hover th-center');

        $display->getColumnFilters()->setPlacement('card.heading');

        return $display;
    }

    /**
     * @param int|null $id
     * @param array $payload
     *
     * @return FormInterface
     */


    /**
     * @return FormInterface
     */
    /*public function onCreate($payload = [])
    {

    }*/

    /**
     * @return bool
     */
    public function isDeletable(Model $model)
    {
        return false;
    }

    /**
     * @return void
     */
    public function onRestore($id)
    {
        // remove if unused
    }
}
