<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Yayasan extends Model
{
    use HasFactory;

    protected $table = 'yayasan';

    protected $fillable = [ 
        'yayasan_id',
        'kategori_pr_id',
        'nik',
        'name',
        'ttl',
        'phone',
        'foto',
        'created_by',
        'modified_by',
    ];
}
