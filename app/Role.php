<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    const ROLE_USER = 'ROLE_USER';
    const ROLE_ADMIN = 'ROLE_ADMIN';
    const ROLE_SUPER_ADMIN = 'ROLE_SUPER_ADMIN';

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function users()
    {
        /**
         * The users that belong to the role.
         */
        return $this->belongsToMany(User::class, 'user_role');
    }

    /**
     * @param $role
     * @return mixed
     */
    public static function getRole($role)
    {
        return Role::where('role_name', $role)->get();
    }
}
