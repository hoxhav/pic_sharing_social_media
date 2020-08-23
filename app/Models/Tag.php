<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $fillable = ['name', 'image_id'];

    public function image()
    {
        return $this->belongsTo('App\Models\Image');
    }

}
