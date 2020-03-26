<?php

namespace App\Repositories;

use App\User;

/**
 * Class UserRepository
 * @package App\Repositories
 */
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
     * @param int $userId
     * @return object
     */
    public function getUserById(int $userId): object
    {
        return $this->user->select()->where('id', $userId)->get()->first();
    }
}
