<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Represents an item.
 *
 * @package App
 */
class Item extends Model
{
    protected $visible = ['id', 'field'];
    protected $fillable = ['field'];

    /**
     * Gets the item's menu relation.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function menu()
    {
        return $this->belongsTo(Menu::class);
    }

    /**
     * Gets the root item relation.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function root()
    {
        return $this->belongsTo(Item::class, 'root_id');
    }

    /**
     * Gets the parent item relation.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function parent()
    {
        return $this->belongsTo(Item::class, 'parent_id');
    }

    /**
     * Gets the children relation.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function children()
    {
        return $this->hasMany(Item::class, 'parent_id');
    }

    /**
     * Gets the descendants relation (all children, including those of child items, etc.).
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function descendants()
    {
        return $this->hasMany(Item::class, 'root_id');
    }
}
