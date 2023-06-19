<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Yayasan extends Model
{
    use HasFactory;

    protected $table = 'yayasan';

    protected $fillable = [ 
        'kategori_pr_id',
        'name',
        'phone',
        'address',
    ];
}
