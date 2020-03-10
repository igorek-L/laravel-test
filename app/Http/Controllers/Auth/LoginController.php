<?php

namespace App\Http\Controllers\Auth;

use App\Services\UserService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\Services\UserTokenGenerator;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    protected $userTokenGenerator;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(
        UserService $userService,
        UserTokenGenerator $userTokenGenerator
    )
    {
        $this->userService = $userService;
        $this->userTokenGenerator = $userTokenGenerator;
        $this->middleware('guest')->except('logout');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $user = $this->userService->retrieveByCredentials(['email' => request('email'), 'password' => request('password')]);

        if (!empty($user)) {

            $token = $this->userTokenGenerator->generateToken();

            $user = $this->userService->updateUserToken($user, $token);

            return response()->json([
                'data' => $user->toArray(),
            ]);
        }

        return response()->json([
            'status' => "401",
            'message' => "Invalid user or password",
        ]);
    }
}
