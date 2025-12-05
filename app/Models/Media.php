<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;   // ← ТОВА ТРЯБВА ДА ГО ДОБАВИШ!

class Media extends Model
{
    protected $fillable = ['name', 'path', 'url', 'mime_type', 'size', 'uploaded_by'];

    public function getThumbnailAttribute()
    {
        if (str_starts_with($this->mime_type, 'image/')) {
            return Storage::url($this->path);
        }

        return asset('/images/og-default.jpg');
    }

    public function getUrlAttribute()
    {
        return Storage::url($this->path);
    }
}