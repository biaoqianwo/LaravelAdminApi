<?php

namespace App\Http\Controllers\V2;

use App\Http\Controllers\Controller;
use App\Http\Middleware\HomeAuthMiddleware;
use App\Models\Article2;
use Illuminate\Http\Request;

class ArticlesController extends Controller
{
    public function __construct()
    {
        $this->middleware(HomeAuthMiddleware::class);
    }

    public function index(Request $request, $pos, $count = 100)
    {
        return Article2::index($request, $pos, $count);
    }

    public function show(Request $request, $uuid)
    {
        return Article2::show($request, $uuid);
    }
}
