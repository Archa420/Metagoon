<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    protected $fillable = [
        'firstname',
        'lastname',
        'username',
        'password',
        'gender',
        'age',
        'role',
        'company_number',
        'company_address',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];
}
