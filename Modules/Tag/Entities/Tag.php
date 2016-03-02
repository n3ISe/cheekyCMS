<?php namespace Modules\Tag\Entities;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    //use Translatable;

    protected $table = 'tags';
    public $translatedAttributes = [];
    protected $fillable = ['name'];
}
