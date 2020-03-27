<?php

namespace App\Services;

use App\{Role, User};
use Illuminate\Support\Facades\{DB, Hash};

/**
 * Class UserService
 * @package App\Services
 */
class UserService
{
    /**
     * Create a new user instance after a valid registration.
     * @param array $data
     * @return User
     */
    public function registerUser(array $data): User
    {
        $user = new User();
        $user->name = $data['name'];
        $user->email = $data['email'];
        $user->password = Hash::make($data['password']);
        $user->phone = $data['phone'];
        $user->address = $data['address'];
        $user->save();
        $user->roles()->attach(Role::getRole(Role::ROLE_USER));

        return $user;
    }

    /**
     * @param User $user
     * @param $token
     * @return User
     */
    public function updateUserToken(User $user, string $token)
    {
        $user->api_token = $token;
        $user->save();

        return $user;
    }

    /**
     * @param array $credentials
     * @return User|null
     */
    public function retrieveByCredentials(array $credentials): ?User
    {
        if (empty($credentials)) {
            return null;
        }

        $user = User::where('email', $credentials['email'])->first();

        if ($user && $this->validatePassword($credentials, $user->getAuthPassword())) {
            return $user;
        } else {
            return null;
        }
    }

    /**
     * @param $credentials
     * @param $password
     * @return bool
     */
    private function validatePassword($credentials, $password): bool
    {
        return Hash::check($credentials['password'], $password);
    }

    /**
     * @param $user
     * @return bool
     */
    public function logOutByToken($user): bool
    {
        return DB::table('users')
            ->where('api_token', $user->api_token)->update(['api_token' => '']);
    }
}
