<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    public $timestamps = false;
    protected $primaryKey = 'id_user';

    protected $fillable = [
        'nama',
        'username',
        'email',
        'password',
        'role',
        'no_hp',
    ];

    protected $hidden = [
        'password',
    ];

    public function getRememberTokenName()
    {
        return null;
    }

    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
    }
}