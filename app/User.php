<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

/**
 * Class User
 * @package App
 */
class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'address', 'phone', 'api_token'
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

    /**
     * The roles that belong to the user.
     */
    public function roles()
    {
        return $this->belongsToMany(Role::class, 'user_role');
    }

    /**
     * The posts that belong to the user
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function posts()
    {
        return $this->hasMany('Posts', 'user_id', 'id');
    }

    /**
     * The comments that belong to the user
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function comments()
    {
        return $this->hasMany('Comments', 'user_id', 'id');
    }

    /**
     * @return bool
     */
    public function hasAdminRole(): bool
    {
        $roles = $this->roles()->where('role_name', Role::ROLE_ADMIN)->get()->all();

        return count($roles) > 0 ? true : false;
    }

    /**
     * @return bool
     */
    public function hasUserRole(): bool
    {
        $roles = $this->roles()->where('role_name', Role::ROLE_USER)->first();

        return !empty($roles) ? true : false;
    }
}
