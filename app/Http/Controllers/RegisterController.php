<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    public function existEmail(Request $request)
    {
        return User::existEmail($request);
    }

    public function existName(Request $request)
    {
        return User::existName($request);
    }

    public function register(Request $request)
    {
        return User::register($request);
    }
}
