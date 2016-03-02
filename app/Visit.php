<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Visit extends Model
{
    protected $table = 'visits';

    public function restaurant () {
    	return $this->hasMany('Modules\Restaurant\Entities\Restaurant');
    }
}
