<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Middleware\AdminAuthMiddleware;
use App\Models\ArticleCate;
use Illuminate\Http\Request;

class ArticleCatesController extends Controller
{
    public function __construct()
    {
        $this->middleware(AdminAuthMiddleware::class);
    }

    public function index(Request $request, $pos, $count = 1000)
    {
        return ArticleCate::index($request, $pos, $count);
    }

    public function store(Request $request)
    {
        return ArticleCate::store($request);
    }

    public function show(Request $request, $uuid)
    {
        return ArticleCate::show($request, $uuid);
    }

    public function edit(Request $request, $uuid)
    {
        return ArticleCate::edit($request, $uuid);
    }

    public function destroy(Request $request, $uuid)
    {
        return ArticleCate::del($request, $uuid);
    }
}
