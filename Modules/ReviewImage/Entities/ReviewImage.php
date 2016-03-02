<?php namespace Modules\ReviewImage\Entities;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class ReviewImage extends Model
{
    //use Translatable;

    protected $table = 'review_image';
    public $translatedAttributes = [];
    protected $fillable = [];
    
    public static function getReviewImage($id)
    {
		$image = ReviewImage::where('id',$id)->value('photo');
		
		return $image;
	}
	
	public function review() {
		return $this->belongsTo('Modules\Review\Entities\Review');
	}
}
