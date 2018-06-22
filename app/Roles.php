<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Roles extends Model
{
    protected $hidden = [
        'created_at', 'updated_at',
    ];

    public function user()
    {
        return $this->hasMany(User::class);
    }
}
