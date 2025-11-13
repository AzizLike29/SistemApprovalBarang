<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'users';
    protected $primaryKey = 'id_users';
    protected $fillable = ['nama', 'email', 'password', 'no_telp', 'telegram_chat_id', 'role', 'remember'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function barangMasuk()
    {
        return $this->hasMany(BarangMasuk::class, 'user_id', 'id_users');
    }

    public function approvals()
    {
        return $this->hasMany(BarangMasuk::class, 'approved_by', 'id_users');
    }
}
