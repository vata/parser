<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Queue extends Model
{
    protected $table = 'queue';

    protected $fillable = [
        'url', 
        'category_id', 
    ];
}
