<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
	protected $table = 'product';

    protected $fillable = [
        'url', 'image', 'sku', 'name', 'description', 'price', 'category_id',
    ];
}
