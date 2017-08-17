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

    public function store(Request $request)
    {
        return File::store($request);
    }

    public function dec(Request $request,$uuid)
    {
        return File::dec($request,$uuid);
    }

    ///////////以下为在素材库操作//////////////

    public function index(Request $request)
    {
        return File::index($request);
    }

    public function media(Request $request)
    {
        return File::media($request);
    }

    public function using(Request $request,$uuid)
    {
        return File::using($request,$uuid);
    }

    public function del(Request $request,$uuid)
    {
        return File::del($request,$uuid);
    }

    public function move(Request $request,$uuid)
    {
        return File::move($request,$uuid);
    }
}
