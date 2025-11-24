<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'description', 'image', 'category_id'];


    /*public function category()
    {
        return $this->belongsTo(Category::class);
    }*/
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'category_news');
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