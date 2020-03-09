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
    }

    public function updateUserToken(User $user, $token)
    {
        $user->api_token = $token;
        $user->save();

        return $user;
    }
}
