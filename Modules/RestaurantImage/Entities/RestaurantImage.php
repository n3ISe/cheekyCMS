<?php namespace Modules\RestaurantImage\Entities;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class RestaurantImage extends Model
{
    //use Translatable;

    protected $table = 'restaurant_image';
    public $translatedAttributes = [];
    protected $fillable = [];
    
    public static function getRestaurantImage($id)
    {
		$image = RestaurantImage::where('id',$id)->value('photo');
		
		return $image;
	}
}
