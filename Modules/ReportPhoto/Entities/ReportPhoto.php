<?php namespace Modules\ReportPhoto\Entities;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class ReportPhoto extends Model
{
    //use Translatable;

    protected $table = 'report_photos';
    public $translatedAttributes = [];
    protected $fillable = [];
    
    public function restaurant() {
		return $this->belongsTo('Modules\Restaurant\Entities\Restaurant');
	}
	
    public function module() {
		return $this->belongsTo('App\ReportModule');
	}
	
    public function reason() {
		return $this->belongsTo('Modules\ReportReason\Entities\ReportReason');
	}
	
}
