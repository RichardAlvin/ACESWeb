<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Model
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $primaryKey = 'id_user';
    public $incrementing = false;

    protected $fillable = ['id_user', 'username', 'password', 'email', 'name', 'role', 'last_login'];
}
