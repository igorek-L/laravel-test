<?php

namespace App\Repositories;

use App\User;

class UserRepository
{
    /**
     * @var User
     */
    protected $user;

    /**
     * UserRepository constructor.
     * @param User $user
     */
    public function __construct(
        User $user
    )
    {
        $this->user = $user;
    }

    /**
     * @param $userId
     * @return mixed
     */
    public function getUserById($userId)
    {
        return $this->user->select()->where('id',$userId)->get()->first();
    }
}
