<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    protected $fillable = [
        'name', 'path', 'tags', 'user_id', 'category_id'
    ];

    public function bookmark()
    {
        return $this->hasMany('App\Models\Bookmark');
    }

    public function category()
    {
        return $this->belongsTo('App\Models\Image');
    }

    public function tag()
    {
        return $this->hasMany('App\Models\Tag');
    }
}
