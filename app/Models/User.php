<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    public $timestamps = false; 

    protected $fillable = [
        'email',
        'password_hash',
        'full_name',
        'role',
    ];

    protected $hidden = [
        'password_hash',
    ];

    /**
     * Our ogtech_db.sql schema stores the hash in `password_hash`
     * instead of Laravel's default `password` column, so point
     * Auth::attempt() at the right column.
     */
    public function getAuthPassword()
    {
        return $this->password_hash;
    }
}