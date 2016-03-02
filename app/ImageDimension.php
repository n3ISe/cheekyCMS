<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ImageDimension extends Model
{
    //
    protected $fillable = ['dimension'];
    protected $table = 'image_dimensions';
}
