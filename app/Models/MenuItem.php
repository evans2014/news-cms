<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MenuItem extends Model
{
    protected $fillable = [
        'title', 'url', 'type', 'target_id', 'order', 'is_active', 'parent_id', 'depth'
    ];

    // ДЕТЕТА
   /* public function children()
    {
        return $this->hasMany(MenuItem::class, 'parent_id')->orderBy('order');
    }*/

    // РОДИТЕЛ
// app/Models/MenuItem.php



    public function children()
    {
        return $this->hasMany(MenuItem::class, 'parent_id')->orderBy('order');
    }

    // НЕ ПРАВИ target() – грешка!
}