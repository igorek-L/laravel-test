<?php

namespace App\Services;

use App\Role;
use App\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserService
{
    /**
     * Get a validator for an incoming registration request.
     *
     * @param array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    public function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'min:4', 'max:20'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'phone' => ['required', 'unique:users', 'regex:/^([0-9\s\-\+\(\)]*)$/', 'min:10']
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param $data
     */
    public function registerUser($data)
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
    public function updateUserToken(User $user, $token)
    {
        $user->api_token = $token;
        $user->save();

        return $user;
    }

    /**
     * @param array $credentials
     * @return bool|void
     */
    public function retrieveByCredentials(array $credentials)
    {
        if (empty($credentials)) {
            return;
        }

        $user = User::where('email', $credentials['email'])->first();

        if ($user && $this->validatePassword($credentials, $user->getAuthPassword())) {
            return $user;
        } else {
            return false;
        }

    }

    /**
     * @param $credentials
     * @param $password
     * @return bool
     */
    private function validatePassword($credentials, $password)
    {
        return Hash::check($credentials['password'], $password);
    }
}
