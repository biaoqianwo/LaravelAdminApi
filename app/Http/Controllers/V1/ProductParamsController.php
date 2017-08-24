<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Middleware\AdminAuthMiddleware;
use App\Models\ProductParam;
use Illuminate\Http\Request;

class ProductParamsController extends Controller
{
    public function __construct()
    {
        $this->middleware(AdminAuthMiddleware::class);
    }

    public function index(Request $request, $pos, $count = 1000)
    {
        return ProductParam::index($request, $pos, $count);
    }

    public function store(Request $request)
    {
        return ProductParam::store($request);
    }

    public function show(Request $request, $uuid)
    {
        return ProductParam::show($request, $uuid);
    }

    public function edit(Request $request, $uuid)
    {
        return ProductParam::edit($request, $uuid);
    }

    public function destroy(Request $request, $uuid)
    {
        return ProductParam::del($request, $uuid);
    }
}
