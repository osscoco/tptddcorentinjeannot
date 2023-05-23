<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'users';
    public $incrementing = true;
    public $timestamps = false;

    protected $fillable = [
        'email',
        'password',
        'firstname',
        'lastname',
        'dateOfBirth',
        'genderId',
        'rightId'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'id' => 'int',
        'rightId' => 'int',
        'genderId' => 'int',
        'email_verified_at' => 'datetime',
        'email_verified_at' => 'dateOfBirth',
        'password' => 'encrypted'
    ];

    public function right()
    {
        return $this->belongsTo(Right::class, 'rightId');
    }

    public function getAuthFullName()
    {
        return $this->firstname . " " . $this->lastname;
    }

    public function getAuthPassword()
    {
        return $this->password;
    }

    public function getRememberToken()
    {
        return $this->remember_token;
    }

    public function setRememberToken($value)
    {
        $this->remember_token = $value;
    }

    public function isAdmin()
    {
        if ($this->right->label == 'Admin') {
            return true;
        }

        return false;
    }
}
