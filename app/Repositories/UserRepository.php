<?php


namespace App\Repositories;

use App\User;

class UserRepository
{
    protected $user;

    public function __construct(
        User $user
    )
    {
        $this->user = $user;
    }

    public function getUserById($userId)
    {
        return $this->user->select()->where('id',$userId)->get()->first();
    }
}
