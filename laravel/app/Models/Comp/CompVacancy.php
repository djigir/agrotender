<?php

namespace App\Models\Comp;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;


/**
 * Class CompVacancy
 * @package App\Models\Comp
 * @property integer $id
 * @property integer $comp_id
 * @property integer $visible
 * @property string  $title
 * @property string  $content
 *
 * @property Carbon $add_date
 */
class CompVacancy extends Model
{
    protected $table = 'comp_vacancy';

    public $timestamps = false;

    protected $fillable = [
        'id',
        'comp_id',
        'visible',
        'title',
        'add_date',
        'content',
    ];

    protected $dates = ['add_date'];
}
