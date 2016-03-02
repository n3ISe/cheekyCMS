<?php namespace Modules\ImageDimension\Entities;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class ImageDimension extends Model
{
    //use Translatable;

    protected $table = 'image_dimensions';
    public $translatedAttributes = [];
    protected $fillable = ['dimension','status'];
}
