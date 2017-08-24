<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Middleware\AdminAuthMiddleware;
use App\Models\ArticleTag;
use Illuminate\Http\Request;

class ArticleTagsController extends Controller
{
    public function __construct()
    {
        $this->middleware(AdminAuthMiddleware::class);
    }

    public function index(Request $request, $pos, $count = 100)
    {
        return ArticleTag::index($request, $pos, $count);
    }

    public function store(Request $request)
    {
        return ArticleTag::store($request);
    }

    public function show(Request $request, $uuid)
    {
        return ArticleTag::show($request, $uuid);
    }

    public function edit(Request $request, $uuid)
    {
        return ArticleTag::edit($request, $uuid);
    }

    public function destroy(Request $request, $uuid)
    {
        return ArticleTag::del($request, $uuid);
    }
}
