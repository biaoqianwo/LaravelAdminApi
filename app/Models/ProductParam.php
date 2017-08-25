<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductParam extends Model
{
    public static function index(Request $request, $offset = 0, $limit = 100)
    {
        $hasPermission = User::hasPermission($request->user, generatePermissionName(__CLASS__, __FUNCTION__));
        if (!$hasPermission) {
            return response()->json(config('tips.user.id.noPermission'));
        }

        $userIds = User::getUidsInSameGroup($request->user);
        $userIds = array_merge([0], $userIds);

        $count = DB::table('product_params')->whereIn('user_id', $userIds)->count();
        $datas = DB::table('product_params')->whereIn('user_id', $userIds)->offset($offset)->limit($limit)->get();

        return response()->json([
                'code' => 0,
                'msg' => 'The product param from ' . $offset . ',len ' . $limit,
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
        $description = $request->input('description', null);
        $values = $request->input('values', null);

        if (!$name) {
            $userIds = User::getUidsInSameGroup($request->user);
            $userIds = array_merge([0], $userIds);
            $count = DB::table('product_params')->whereIn('user_id', $userIds)->where('name', $name)->count();
            if ($count) {
                return response()->json(config('tips.productParam.existing'));
            }
        }

        $data = [
            'user_id' => $request->user->id,
            'uuid' => iGenerateUuid(),
            'name' => $name,
            'description' => $description,
            'values' => $values,
            'created_at' => time(),
            'updated_at' => time(),
        ];
        DB::table('product_params')->insertGetId($data);

        return response()->json([
            'code' => 0,
            'msg' => 'The product param store successfully',
            'data' => $data,
        ]);
    }

    public static function show(Request $request, $uuid)
    {
        $userIds = User::getUidsInSameGroup($request->user);
        $userIds = array_merge([0], $userIds);
        $data = DB::table('product_params')->whereIn('user_id', $userIds)->where('uuid', $uuid)->first();
        if (!$data) {
            return response()->json(config('tips.productParam.empty'));
        }

        $data->permissionName = generatePermissionName(__CLASS__, __FUNCTION__);
        $hasPermission = User::hasPermission($request->user, $data);
        if (!$hasPermission) {
            return response()->json(config('tips.user.id.noPermission'));
        }
        unset($data->permissionName);

        return response()->json([
                'code' => 0,
                'msg' => 'The product param show successfully',
                'data' => $data,
            ]
        );
    }

    public static function edit(Request $request, $uuid)
    {
        $name = $request->input('name', null);
        $description = $request->input('description', null);
        $values = $request->input('values', null);

        if (!$name) {
            $userIds = User::getUidsInSameGroup($request->user);
            $userIds = array_merge([0], $userIds);

            $count = DB::table('product_params')->whereIn('user_id', $userIds)->where('name', $name)->where('uuid', '<>',
                $uuid)->count();
            if ($count) {
                return response()->json(config('tips.productParam.existing'));
            }
        }

        $model = DB::table('product_params')->where('uuid', $uuid)->first();
        if(!$model){
            return response()->json(config('tips.productParam.empty'));
        }

        $model->permissionName = generatePermissionName(__CLASS__, __FUNCTION__);
        $hasPermission = User::hasPermission($request->user, $model);
        if (!$hasPermission) {
            return response()->json(config('tips.user.id.noPermission'));
        }


        $data = ['updated_at' => time(),];
        if ($name) {
            $data['name'] = $name;
        }
        if ($description) {
            $data['description'] = $description;
        }
        if ($values) {
            $data['values'] = $values;
        }
        $result = DB::table('product_params')->where('uuid', $uuid)->update($data);
        if (!$result) {
            return response()->json(config('tips.productParam.edit.failure'));
        }
        return response()->json([
            'code' => 0,
            'msg' => 'The product param edit successfully',
            'data' => $data,
        ]);
    }

    public static function del(Request $request, $uuid)
    {
        $model = DB::table('product_params')->where('uuid', $uuid)->first();
        if(!$model){
            return response()->json(config('tips.productParam.empty'));
        }

        $model->permissionName = generatePermissionName(__CLASS__, __FUNCTION__);
        $hasPermission = User::hasPermission($request->user, $model, 1);
        if (!$hasPermission) {
            return response()->json(config('tips.user.id.noPermission'));
        }

        $result = DB::table('product_params')->where('uuid', $uuid)->delete();
        if (!$result) {
            return response()->json(config('tips.productParam.delete.failure'));
        }

        return response()->json([
                'code' => 0,
                'msg' => 'The product param delete successfully',
            ]
        );
    }
}
