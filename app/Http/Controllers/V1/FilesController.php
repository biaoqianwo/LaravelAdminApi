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

    public function index(Request $request, $pos, $count = 100)
    {
        return File::index($request, $pos, $count);
    }

    public function store(Request $request)
    {
        return File::store($request);
    }

    public function move(Request $request, $uuid)
    {
        return File::move($request, $uuid);
    }

    public function rename(Request $request, $uuid)
    {
        return File::rename($request, $uuid);
    }

    public function del(Request $request, $uuid)
    {
        return File::del($request, $uuid);
    }
}
