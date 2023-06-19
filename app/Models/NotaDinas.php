<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NotaDinas extends Model
{
    use HasFactory;
    
     protected $table = 'nota_dinas';

    protected $fillable = [ 
    	'yayasan_id',
    	'p_rentan_id',
    	'file'
    ];
}
