<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bookmark extends Model
{
    public function image()
    {
        return $this->belongsTo('App\Models\Image');
    }
}
