<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
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

}
