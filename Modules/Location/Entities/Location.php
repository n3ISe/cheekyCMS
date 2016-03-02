<?php namespace Modules\Location\Entities;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    //use Translatable;

    protected $fillable = ['name','city','region','country','coord_lat','coord_long'];

    protected $table = 'locations';

    public function restaurants () {
    	return $this->hasMany('Modules\Restaurant\Entities\Restaurant');
    }
}
