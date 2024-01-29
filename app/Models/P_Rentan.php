<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class P_Rentan extends Model
{
    use HasFactory;

    protected $table = 'p_rentan';

    protected $fillable = [
        'yayasan_id',
        'kategori_pr_id',
        'nik',
        'name',
        'gender',
        'ttl',
        'lampiran',
        'address'
    ];

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
