<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class PasswordReset extends Eloquent
{
    use HasFactory;
    protected $collection = 'password_resets';
    protected $fillable = [
        'email',
        'token',
        'created_at',
    ];
}
