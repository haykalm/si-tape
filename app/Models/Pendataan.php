<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pendataan extends Model
{
    use HasFactory;

    protected $table = 'pendataan';

    protected $fillable = [ 
        'p_rentan_id',
        'kode_pendataan'
    ];
}
