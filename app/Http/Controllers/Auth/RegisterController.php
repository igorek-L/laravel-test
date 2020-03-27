<?php

namespace App\Http\Controllers\Auth;

use App\Http\Requests\RegisterUser;
use App\Http\Controllers\Controller;
use App\Services\UserService;
use Illuminate\Http\Request;

/**
 * Class RegisterController
 * @package App\Http\Controllers\Auth
 */
class RegisterController extends Controller
{
    /**
     * @var UserService
     */
    private $userService;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(
        UserService $userService
    )
    {
        $this->userService = $userService;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(RegisterUser $request)
    {
        $validated = $request->validated();

        $this->userService->registerUser($validated);

        return \response()->json(
            [
                "status" => "success",
                "message" => "User created",
                "code" => 201
            ]
        );
    }
}
