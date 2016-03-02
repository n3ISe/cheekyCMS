<?php namespace Modules\Review\Entities;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
   // use Translatable;

    protected $table = 'reviews';
    public $translatedAttributes = [];
    protected $fillable = [];
    
    public function user() 
	{
		return $this->belongsTo('Modules\ApiUser\Entities\ApiUser');
	}
    
    public function restaurant() 
	{
		return $this->belongsTo('Modules\Restaurant\Entities\Restaurant');
	}
	
	public function reviewImages () {
    	return $this->hasMany('Modules\ReviewImage\Entities\ReviewImage');
    }
}
