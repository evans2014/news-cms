<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class News extends Model
{
    use HasFactory;use SoftDeletes;

    protected $fillable = ['title', 'description', 'image', 'category_id'];
    protected $dates = ['deleted_at'];

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'category_news')->withTimestamps();;
    }



    protected static function boot()
    {
        parent::boot();

        static::saving(function ($news) {
            $news->title = mb_convert_case($news->title, MB_CASE_TITLE, "UTF-8");
            $news->title_lower = mb_strtolower($news->title, 'UTF-8');
            $news->description_lower = mb_strtolower($news->description ?? '', 'UTF-8');
        });
    }


}