<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;
use Jenssegers\Mongodb\Auth\User as Authenticatable;

class Agent extends Authenticatable
{
    use HasFactory;
    protected $collection = 'agent';
    protected $fillable = [
        'name',
        'rfid_tags',
        'contact_no',   
        'images',
        'email',
        'username',
        'address',
        'description',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
