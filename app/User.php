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
    protected $fillable = [
        'name', 'email', 'password', 'company_id', 'role_id',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function scopeWithUserLogin($query)
     {
          return $query->where('id', '=', \Auth::guard('admin')->id())->first();
     }

    public function Role()
    {
         return $this->hasOne('App\Models\Role', 'id', 'role_id');
    }

    public function Company()
    {
         return $this->hasOne('App\Models\Company', 'id', 'company_id');
    }
}
