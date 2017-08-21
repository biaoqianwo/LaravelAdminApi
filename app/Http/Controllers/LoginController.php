<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class LoginController extends Controller
{

    public function login(Request $request)
    {
        return User::login($request);
    }
}
