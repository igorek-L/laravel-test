<?php

namespace App\Services;

use Illuminate\Support\Str;

/**
 * Class UserTokenGenerator
 * @package App\Services
 */
class UserTokenGenerator
{
    /**
     * @return string
     */
    public function generateToken(): string
    {
        return Str::random(60);
    }
}

