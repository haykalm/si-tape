<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Event extends Model
{
    use HasFactory;

    protected $table = 'events';

    protected $fillable = [
    	'p_rentan_id',
    	'yayasan_id',
    	'event_name',
    	'event_location',
    	'date'
    ];

    public function image()
    {
        return $this->hasMany(EventImages::class, 'event_id');
    }

    function scopeFilterMonthYear($query, array $monthYear)
    {
        $start = '';
        $end = '';
        if(!empty($monthYear['month_year'])){
            $start = Carbon::parse($monthYear['month_year'])->firstOfMonth()->format('Y-m-d H:i:s');
            $end = Carbon::parse($monthYear['month_year'])->lastOfMonth()->format('Y-m-d H:i:s');
        }

        $query->when($monthYear['month_year'] ?? false, function ($query, $monthYear) use ($start,$end){
            return $query->whereBetween('created_at', [$start,$end]);
        });
    }
}
