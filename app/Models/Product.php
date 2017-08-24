<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Product extends Model
{
    public static function index(Request $request, $offset = 0, $limit = 100)
    {
        $hasPermission = User::hasPermission($request->user, generatePermissionName(__CLASS__, __FUNCTION__));
        if (!$hasPermission) {
            return response()->json(config('tips.user.id.noPermission'));
        }

        $userIds = User::getUidsInSameGroup($request->user);

        $count = DB::table('products')->whereIn('user_id', $userIds)->count();
        if (!$count) {
            return response()->json(config('tips.product.empty'));
        }

        $datas = DB::table('products')->whereIn('user_id', $userIds)->offset($offset)->limit($limit)->get();
        return response()->json([
                'code' => 0,
                'msg' => 'The product from ' . $offset . ',len ' . $limit,
                'data' => $datas,
                'count' => $count,
            ]
        );
    }

    public static function store(Request $request)
    {
        $hasPermission = User::hasPermission($request->user, generatePermissionName(__CLASS__, __FUNCTION__));
        if (!$hasPermission) {
            return response()->json(config('tips.user.id.noPermission'));
        }

        $name = $request->input('name', null);
        if (!$name) {
            return response()->json(config('tips.product.name.required'));
        }
        $code = $request->input('code', null);
        if ($code) {
            $userIds = User::getUidsInSameGroup($request->user);
            $count = DB::table('products')->whereIn('user_id', $userIds)->where('code', $code)->count();
            if ($count) {
                return response()->json(config('tips.product.code.existing'));
            }
        }

        $data = [
            'user_id' => $request->user->id,
            'uuid' => iGenerateUuid(),
            'code' => $code,
            'name' => $name,
            'attrs' => $request->input('attrs', null),
            'alias' => $request->input('alias', null),
            'picture' => $request->input('picture', null),
            'params' => $request->input('params', null),
            'url' => $request->input('url', null),
            'detail' => $request->input('detail', null),
            'status' => (int)$request->input('status', 1),
            'created_at' => time(),
            'updated_at' => time(),
        ];
        DB::table('products')->insertGetId($data);

        return response()->json([
            'code' => 0,
            'msg' => 'The product store successfully',
            'data' => $data,
        ]);
    }

    public static function show(Request $request, $uuid)
    {
        $userIds = User::getUidsInSameGroup($request->user);

        $data = DB::table('products')->whereIn('user_id', $userIds)->where('uuid', $uuid)->first();
        if (!$data) {
            return response()->json(config('tips.product.empty'));
        }

        $data->permissionName = generatePermissionName(__CLASS__, __FUNCTION__);
        $hasPermission = User::hasPermission($request->user, $data);
        if (!$hasPermission) {
            return response()->json(config('tips.user.id.noPermission'));
        }
        unset($data->permissionName);

        return response()->json([
                'code' => 0,
                'msg' => 'The product show successfully',
                'data' => $data,
            ]
        );
    }

    public static function edit(Request $request, $uuid)
    {
        $name = $request->input('name', null);
        $code = $request->input('code', null);
        $alias = $request->input('alias', null);
        $attrs = $request->input('attrs', null);
        $params = $request->input('params', null);
        $url = $request->input('url', null);
        $detail = $request->input('detail', null);
        $status = (int)$request->input('status', -1);

        if ($code) {
            $userIds = User::getUidsInSameGroup($request->user);
            $count = DB::table('products')->whereIn('user_id', $userIds)->where('code', $code)->count();
            if ($count) {
                return response()->json(config('tips.product.existing'));
            }
        }

        $model = DB::table('products')->where('uuid', $uuid)->first();
        if(!$model){
            return response()->json(config('tips.product.empty'));
        }

        $model->permissionName = generatePermissionName(__CLASS__, __FUNCTION__);
        $hasPermission = User::hasPermission($request->user, $model);
        if (!$hasPermission) {
            return response()->json(config('tips.user.id.noPermission'));
        }

        $data = ['updated_at' => time()];
        if ($code) {
            $data['code'] = $code;
        }
        if ($name) {
            $data['name'] = $name;
        }
        if ($alias) {
            $data['alias'] = $alias;
        }
        if ($attrs) {
            $data['attrs'] = $attrs;
        }
        if ($params) {
            $data['params'] = $params;
        }
        if ($url) {
            $data['url'] = $url;
        }
        if ($detail) {
            $data['detail'] = $detail;
        }
        if ($status >= 0) {
            $data['status'] = $status;
        }

        $result = DB::table('products')->where('uuid', $uuid)->update($data);
        if (!$result) {
            return response()->json(config('tips.product.edit.failure'));
        }

        return response()->json([
            'code' => 0,
            'msg' => 'The product edit successfully',
            'data' => $data,
        ]);
    }

    public static function del(Request $request, $uuid)
    {
        $model = DB::table('products')->where('uuid', $uuid)->first();
        if(!$model){
            return response()->json(config('tips.product.empty'));
        }
        $model->permissionName = generatePermissionName(__CLASS__, __FUNCTION__);
        $hasPermission = User::hasPermission($request->user, $model, 1);
        if (!$hasPermission) {
            return response()->json(config('tips.user.id.noPermission'));
        }

        $result = DB::table('products')->where('uuid', $uuid)->delete();
        if (!$result) {
            return response()->json(config('tips.product.delete.failure'));
        }

        return response()->json([
                'code' => 0,
                'msg' => 'The product delete successfully',
            ]
        );
    }
}
