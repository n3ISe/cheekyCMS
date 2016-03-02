<?php namespace Modules\Menus\Entities;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class Menus extends Model
{
    //use Translatable;

    protected $table = 'menus';
    public $translatedAttributes = [];
    protected $fillable = [];
    
    public function restaurant () {
    	return $this->belongsTo('Modules\Restaurant\Entities\Restaurant');
    }
}
