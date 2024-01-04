<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class Category extends Eloquent
{
    use HasFactory;

    protected $collection = 'category';
    protected $fillable = [
        'name',
        'description',   
    ];
}
