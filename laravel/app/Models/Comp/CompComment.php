<?php

namespace App\Models\Comp;

use Illuminate\Database\Eloquent\Model;

/**
 * @property  integer $id;
 * @property  integer $item_id;
 * @property  integer $visible;
 * @property  integer $rate;
 * @property  string  $author;
 * @property  string  $author_email;
 * @property  string  $ddchk_guid;
 * @property  integer $reply_to_id;
 * @property  integer $author_id;
 * @property  integer $like_yes;
 * @property  integer $like_no;
 * @method static create(array $data)
 * @method static update(array $data)
 * @method static updateOrCreate(array $array, array $data)
 *
 * @param \DateTime $add_date;
 */

class CompComment extends Model
{
    protected $table = 'comp_comment';

    public $timestamps = false;

    protected $fillable = [
        'id',
        'item_id',
        'visible',
        'rate',
        'add_date',
        'author',
        'author_email',
        'ddchk_guid',
        'reply_to_id',
        'author_id',
        'like_yes',
        'like_no',
    ];

    protected $appends = ['company', 'comment_lang'];

    public function getCompanyAttribute()
    {
        $company = CompItems::where('author_id', $this->author_id)->select('id', 'title', 'author_id', 'logo_file')->get()->toArray();
        if(!empty($company)){
            return $company[0];
        }
        return [];
    }

    public function getCommentLangAttribute()
    {
        return CompCommentLang::where('item_id', $this->id)->get()->toArray()[0];
    }
    public function comp_comment_lang()
    {
        return $this->hasOne(CompCommentLang::class, 'item_id');
    }

    public function comp_item()
    {
        return $this->hasMany(CompItems::class, 'author_id', 'author_id');
    }
}
