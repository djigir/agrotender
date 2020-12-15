<?php

namespace App\Models\Users;

use Illuminate\Database\Eloquent\Model;

class UserGroups extends Model
{
    protected $table = 'user_groups';

    protected $fillable = [
        'id',
        'group_name',
    ];

    public function users()
    {
        return $this->belongsTo(Users::class, 'group_id');
    }
}
