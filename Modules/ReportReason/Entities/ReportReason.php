<?php namespace Modules\ReportReason\Entities;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class ReportReason extends Model
{
    //use Translatable;

    protected $table = 'report_reason';
    public $translatedAttributes = [];
    protected $fillable = ['reason','status'];
    
    public function restaurant() {
		return $this->belongsToMany('Modules\Restaurant\Entities\Restaurant');
	}
}
