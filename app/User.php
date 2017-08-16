<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    protected $table = 'user';

    protected $fillable = [
        'user_name',
        'password',
        'remember_token',
        'email',
        'gender',
        'created_at',
        'updated_at',
    ];

    protected $guarded = [];
}
