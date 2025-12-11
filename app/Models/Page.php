<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Page extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['slug', 'title', 'content'];
    protected $dates = ['deleted_at'];

   /* protected static function booted()
    {
        // При soft delete
        static::deleting(function ($page) {
            $page->is_trashed = true;
            $page->saveQuietly();
        });

        // При restore
        static::restoring(function ($page) {
            $page->is_trashed = false;
            $page->saveQuietly();
        });
    }*/

}