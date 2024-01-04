<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    use HasFactory;
    protected $collection = 'admin';
    protected $fillable = [
        'name',
        'rfid_tags',
        'contact_no',   
        'email',
        'username',
        'address',
        'password',
    ];

    protected $hidden = [
        'password',
    ];
}
