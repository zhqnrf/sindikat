<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'mou_id',
        'is_approved'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function mou()
    {
        return $this->belongsTo(Mou::class);
    }
}
