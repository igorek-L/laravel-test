<?php

namespace App\Http\Controllers\Auth;

use Exception;
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
    public function register(Request $request)
    {
        try {
            $this->userService->validator($request->all())->validate();
        } catch (Exception $e) {
            report($e);
            return \response()->json(
                [
                    "status" => "Unprocessable Entity",
                    "message" => $e->getMessage(),
                    "code" => $e->status
                ]
            );
        }

        $this->userService->registerUser($request);

        return \response()->json(
            [
                "status" => "success",
                "message" => "User created",
                "code" => 201
            ]
        );
    }
}
