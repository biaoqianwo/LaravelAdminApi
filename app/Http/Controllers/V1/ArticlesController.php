<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Middleware\AdminAuthMiddleware;
use App\Models\Article;
use Illuminate\Http\Request;

class ArticlesController extends Controller
{
    public function __construct()
    {
        $this->middleware(AdminAuthMiddleware::class);
    }

    public function index(Request $request)
    {
        return Article::index($request);
    }

    public function store(Request $request)
    {
        return Article::store($request);
    }

    public function show(Request $request, $uuid)
    {
        return Article::show($request, $uuid);
    }

    public function edit(Request $request, $uuid)
    {
        return Article::edit($request, $uuid);
    }

    public function destroy(Request $request, $uuid)
    {
        return Article::del($request, $uuid);
    }
}
