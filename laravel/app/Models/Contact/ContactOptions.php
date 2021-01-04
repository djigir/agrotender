<?php

namespace App\Models\Contact;

use Illuminate\Database\Eloquent\Model;

class ContactOptions extends Model
{
    protected $table = 'contact_options';
    public $timestamps  = false;
    protected $fillable = ['id', 'value', 'lang_id'];
}
