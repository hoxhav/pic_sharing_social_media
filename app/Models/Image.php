<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    protected $fillable = [
        'name', 'path', 'tags', 'user_id', 'category_id'
    ];
}
