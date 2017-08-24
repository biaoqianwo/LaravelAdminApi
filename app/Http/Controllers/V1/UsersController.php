<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Middleware\AdminAuthMiddleware;
use App\Models\User;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    public function __construct()
    {
        $this->middleware(AdminAuthMiddleware::class);
    }

    public function index(Request $request, $pos, $count = 1000)
    {
        return User::index($request, $pos, $count);
    }

    public function store(Request $request)
    {
        return User::store($request);
    }

    public function show(Request $request, $uuid)
    {
        return User::show($request, $uuid);
    }

    public function edit(Request $request, $uuid)
    {
        return User::edit($request, $uuid);
    }

    public function destroy(Request $request, $uuid)
    {
        return User::del($request, $uuid);
    }
}
