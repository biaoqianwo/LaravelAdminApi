<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Middleware\AdminAuthMiddleware;
use App\Models\File;
use Illuminate\Http\Request;

class FilesController extends Controller
{
    public function __construct()
    {
        $this->middleware(AdminAuthMiddleware::class);
    }

    public function index(Request $request)
    {
        return File::index($request);
    }

    public function store(Request $request)
    {
        return File::store($request);
    }

    public function move(Request $request, $uuid)
    {
        return File::move($request, $uuid);
    }

    public function del(Request $request, $uuid)
    {
        return File::del($request, $uuid);
    }
}
