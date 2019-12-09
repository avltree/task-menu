<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    protected $fillable = ['field', 'max_depth', 'max_children'];
    protected $attributes = [
        'max_depth' => 5,
        'max_children' => 5
    ];
    protected $hidden = ['created_at', 'updated_at'];
}
