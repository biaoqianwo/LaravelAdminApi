<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Middleware\AdminAuthMiddleware;
use App\Models\Config;
use Illuminate\Http\Request;

class ConfigsController extends Controller
{
    public function __construct()
    {
        $this->middleware(AdminAuthMiddleware::class);
    }

    public function index(Request $request, $pos, $count = 100)
    {
        return Config::index($request, $pos, $count);
    }

    public function store(Request $request)
    {
        return Config::store($request);
    }

    public function show(Request $request, $uuid)
    {
        return Config::show($request, $uuid);
    }

    public function edit(Request $request, $uuid)
    {
        return Config::edit($request, $uuid);
    }

    public function destroy(Request $request, $uuid)
    {
        return Config::del($request, $uuid);
    }
}
