<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Middleware\AdminAuthMiddleware;
use App\Models\Folder;
use Illuminate\Http\Request;

class FoldersController extends Controller
{
    public function __construct()
    {
        $this->middleware(AdminAuthMiddleware::class);
    }

    public function store(Request $request)
    {
        return Folder::store($request);
    }

    public function edit(Request $request, $uuid)
    {
        return Folder::edit($request, $uuid);
    }

    public function destroy(Request $request, $uuid)
    {
        return Folder::del($request, $uuid);
    }
}
