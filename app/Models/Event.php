<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $table = 'events';

    protected $fillable = [ 
    	'user_id',
    	'yayasan_id',
    	'event_name',
    	'event_location',
    	'date'
    ];

    public function image() 
    {
        return $this->hasMany(EventImages::class, 'event_id');
    }
}
