<?php namespace Modules\Feedback\Entities;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    //use Translatable;

    protected $table = 'feedbacks';
    public $translatedAttributes = [];
    protected $fillable = [];
}
