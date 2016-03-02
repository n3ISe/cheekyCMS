<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bookmark extends Model
{
    protected $table = 'bookmarks';

    public function restaurant () {
    	return $this->hasMany('Modules\Restaurant\Entities\Restaurant');
    }
}
