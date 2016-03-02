<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    protected $table = 'likes';

    public function restaurant () {
    	return $this->hasMany('Modules\Restaurant\Entities\Restaurant');
    }
}
