<?php namespace Modules\CuisineType\Entities;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class CuisineType extends Model
{
    //use Translatable;

    protected $table = 'cuisine_types';
    public $translatedAttributes = [];
    protected $fillable = ['name'];
    
    public function restaurant () {
    	return $this->hasMany('Modules\Restaurant\Entities\Restaurant');
    }
}
