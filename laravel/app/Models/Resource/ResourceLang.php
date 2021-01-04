<?php

namespace App\Models\Resource;

use Illuminate\Database\Eloquent\Model;

class ResourceLang extends Model
{
    protected $table = 'resource_lang';
    public $timestamps  = false;
    protected $fillable = ['id', 'item_id', 'lang_id', 'content'];


    public function resource()
    {
        return $this->belongsTo(Resource::class, 'id', 'item_id');
    }
}
