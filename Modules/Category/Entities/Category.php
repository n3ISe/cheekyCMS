<?php namespace Modules\Category\Entities;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
   // use Translatable;

    protected $table = 'categories';
    public $translatedAttributes = [];
    protected $fillable = ['name'];
}
