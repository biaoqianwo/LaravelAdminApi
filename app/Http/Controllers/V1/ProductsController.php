<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Middleware\AdminAuthMiddleware;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductsController extends Controller
{
    public function __construct()
    {
        $this->middleware(AdminAuthMiddleware::class);
    }

    public function index(Request $request)
    {
        return Product::index($request);
    }

    public function store(Request $request)
    {
        return Product::store($request);
    }

    public function show(Request $request, $uuid)
    {
        return Product::show($request, $uuid);
    }

    public function edit(Request $request, $uuid)
    {
        return Product::edit($request, $uuid);
    }

    public function destroy(Request $request, $uuid)
    {
        return Product::del($request, $uuid);
    }
}
