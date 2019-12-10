<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $visible = ['id', 'field'];
    protected $fillable = ['field'];

    public function menu()
    {
        return $this->belongsTo(Menu::class);
    }

    public function root()
    {
        return $this->belongsTo(Item::class, 'root_id');
    }

    public function parent()
    {
        return $this->belongsTo(Item::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(Item::class, 'parent_id');
    }

    public function descendants()
    {
        return $this->hasMany(Item::class, 'root_id');
    }
}
