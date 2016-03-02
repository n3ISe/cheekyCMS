<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ReportModule extends Model
{
    //
    protected $fillable = ['name'];
    
    protected $table = 'report_module';
    
    public function reportPhoto() {
		return $this->hasMany('Modules\ReportPhoto\Entities\ReportPhoto');
	}
}
