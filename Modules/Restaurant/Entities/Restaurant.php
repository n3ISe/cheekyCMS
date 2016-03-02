<?php namespace Modules\Restaurant\Entities;

use App\RestaurantTag;
use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class Restaurant extends Model
{
    //use Translatable;

    protected $table = 'restaurants';
    public $translatedAttributes = [];
    protected $fillable = [
		'name',
		'location_id',
		'address',
		'coord_lat',
		'coord_long',
		'category_id',
		'cuisine_type_id',
		'phone_number',
		'price_w_champaign',
		'price_w_alcohol',
		'price_wo_alcohol',
		'price_children',
		'description',
		'active',
	];
	
	public function hasTagId($tagId,$restaurantId)
    {
        return RestaurantTag::where('tag_id',$tagId)->where('restaurant_id',$restaurantId)->count() >= 1;
    }
	
	public function updateAndSyncTags($restaurantId, $data, $tags)
    {
        $restaurant = Restaurant::findOrFail($restaurantId);
		$restaurant->update($data);

        if (!empty($tags)) 
        {
			RestaurantTag::where('restaurant_id',$restaurantId)->delete();
			foreach ($tags as $tag) 
			{
				$dataSet[] = [
					'restaurant_id'  => $restaurantId,
					'tag_id'    => $tag,
				];
			}
			
			RestaurantTag::insert($dataSet);
        }
    }
	
	public function getDates() {
	    return array();
	}
	
	public function location() {
		return $this->belongsTo('Modules\Location\Entities\Location');
	}

	public function category() {
		return $this->belongsTo('Modules\Category\Entities\Category');
	}

	public function cuisineType() {
		return $this->belongsTo('Modules\CuisineType\Entities\CuisineType');
	}
	
	public function tags() {
		return $this->belongsToMany('Modules\Tag\Entities\Tag');
	}
	
	public function menus() {
		return $this->hasMany('Modules\Menus\Entities\Menus');
	}
	
	public function assets() {
		return $this->hasMany('Modules\Asset\Entities\Asset');
	}
	
	public function reportPhoto() {
		return $this->hasMany('Modules\ReportPhoto\Entities\ReportPhoto');
	}
	
	public function reviews () {
    	return $this->hasMany('Modules\Review\Entities\Review');
    }
}
