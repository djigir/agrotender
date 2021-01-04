<?php

namespace App\Models\Preferences;

use Illuminate\Database\Eloquent\Model;

class Preferences extends Model
{
    protected $table = 'preferences';
    public $timestamps  = false;
    protected $fillable = ['id', 'value'];
}
