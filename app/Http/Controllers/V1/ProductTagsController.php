<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Middleware\AdminAuthMiddleware;
use App\Models\ProductTag;
use Illuminate\Http\Request;

class ProductTagsController extends Controller
{
    public function __construct()
    {
        $this->middleware(AdminAuthMiddleware::class);
    }

    public function index(Request $request)
    {
        return ProductTag::index($request);
    }

    public function store(Request $request)
    {
        return ProductTag::store($request);
    }

    public function show(Request $request, $uuid)
    {
        return ProductTag::show($request, $uuid);
    }

    public function edit(Request $request, $uuid)
    {
        return ProductTag::edit($request, $uuid);
    }

    public function destroy(Request $request, $uuid)
    {
        return ProductTag::del($request, $uuid);
    }
}
