<?php

namespace App\Http\Controllers\Auth;

use Exception;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Services\UserService;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;

/**
 * Class RegisterController
 * @package App\Http\Controllers\Auth
 */
class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * @var UserService
     */
    private $userService;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(
        UserService $userService
    )
    {
        // $this->middleware('guest');
        $this->userService = $userService;
    }

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
