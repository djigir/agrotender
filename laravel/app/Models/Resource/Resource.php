<?php

namespace App\Models\Resource;

use Illuminate\Database\Eloquent\Model;

class Resource extends Model
{
    protected $table = 'resource';
    public $timestamps  = false;
    protected $fillable = ['id', 'name', 'title'];

    public function resourceLang()
    {
        return $this->hasOne(ResourceLang::class, 'item_id', 'id');
    }

}
