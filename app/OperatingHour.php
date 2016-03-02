<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OperatingHour extends Model
{
    protected $table = 'operating_hours';

    protected $fillable = [
        'restaurant_id',
        'day',
        'open',
        'close',
    ];

    protected $hidden = ['created_at', 'updated_at'];
}
