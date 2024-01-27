<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
}
