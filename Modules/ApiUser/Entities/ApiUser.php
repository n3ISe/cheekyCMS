<?php namespace Modules\ApiUser\Entities;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class ApiUser extends Model
{
    //use Translatable;

    protected $table = 'users';
    public $translatedAttributes = [];
    protected $fillable = ['name', 'email', 'password'];
    protected $hidden = ['password', 'remember_token'];
    
    public function setPasswordAttribute($password)
    {   
        $this->attributes['password'] = bcrypt($password);
    }
    
    public function reviews () {
    	return $this->hasMany('Modules\Review\Entities\Review');
    }
}
