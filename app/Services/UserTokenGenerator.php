<?php

namespace App\Services;

use Illuminate\Support\Str;

class UserTokenGenerator
{
    /**
     * @return string
     */
    public function generateToken()
    {
        return Str::random(60);
    }
}

