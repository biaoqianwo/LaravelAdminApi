<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Middleware\AdminAuthMiddleware;
use App\Models\ProductAttr;
use Illuminate\Http\Request;

class ProductAttrsController extends Controller
{
    public function __construct()
    {
        $this->middleware(AdminAuthMiddleware::class);
    }

    public function index(Request $request, $pos, $count = 100)
    {
        return ProductAttr::index($request, $pos, $count);
    }

    public function store(Request $request)
    {
        return ProductAttr::store($request);
    }

    public function show(Request $request, $uuid)
    {
        return ProductAttr::show($request, $uuid);
    }

    public function edit(Request $request, $uuid)
    {
        return ProductAttr::edit($request, $uuid);
    }

    public function destroy(Request $request, $uuid)
    {
        return ProductAttr::del($request, $uuid);
    }
}
