<?php
namespace App\Http\Controllers\User;


use App\Http\Controllers\Controller;
use Illuminate\Routing\Route;

class UserController extends Controller
{
    public function index(){
        return view('user.profile');
    }
}
