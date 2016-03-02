<?php namespace Modules\Asset\Entities;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class Asset extends Model
{
    //use Translatable;

    protected $table = 'restaurant_assets';
    public $translatedAttributes = [];
    protected $fillable = [];
    
    public function restaurant () {
    	return $this->belongsTo('Modules\Restaurant\Entities\Restaurant');
    }
}
