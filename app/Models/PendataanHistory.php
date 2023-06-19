<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PendataanHistory extends Model
{
    use HasFactory;

    protected $table = 'pendataan_history';

    protected $fillable = [ 
        'pendataan_id',
        'pendataan_date'
    ];
}
