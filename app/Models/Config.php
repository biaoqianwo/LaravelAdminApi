<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Config extends Model
{
    public static function index(Request $request, $offset = 0, $limit = 100)
    {
        $hasPermission = User::hasPermission($request->user, generatePermissionName(__CLASS__, __FUNCTION__));
        if (!$hasPermission) {
            return response()->json(config('tips.user.id.noPermission'));
        }

        $userIds = User::getUidsInSameGroup($request->user);

        // todo 缓存
        $count = DB::table('configs')->whereIn('user_id', $userIds)->count();
        if (!$count) {
            return response()->json(config('tips.config.empty'));
        }

        $datas = DB::table('configs')->whereIn('user_id', $userIds)->offset($offset)->limit($limit)->get();

        return response()->json([
                'code' => 0,
                'msg' => 'The config from ' . $offset . ',len ' . $limit,
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

        $key = $request->input('key', null);
        $description = $request->input('description', null);
        $value = $request->input('value', null);
        if (!$key) {
            return response()->json(config('tips.config.key.required'));
        }

        $userIds = User::getUidsInSameGroup($request->user);
        $count = DB::table('configs')->whereIn('user_id', $userIds)->where('key', $key)->count();
        if ($count) {
            return response()->json(config('tips.config.key.existing'));
        }

        $data = [
            'user_id' => $request->user->id,
            'uuid' => iGenerateUuid(),
            'key' => $key,
            'description' => $description,
            'value' => $value,
            'created_at' => time(),
            'updated_at' => time(),
        ];
        DB::table('configs')->insertGetId($data);

        return response()->json([
            'code' => 0,
            'msg' => 'The config store successfully',
            'data' => $data,
        ]);
    }

    public static function show(Request $request, $uuid)
    {
        $userIds = User::getUidsInSameGroup($request->user);

        $data = DB::table('configs')->whereIn('user_id', $userIds)->where('uuid', $uuid)->first();
        if (!$data) {
            return response()->json(config('tips.config.empty'));
        }

        $data->permissionName = generatePermissionName(__CLASS__, __FUNCTION__);
        $hasPermission = User::hasPermission($request->user, $data);
        if (!$hasPermission) {
            return response()->json(config('tips.user.id.noPermission'));
        }
        unset($data->permissionName);

        return response()->json([
                'code' => 0,
                'msg' => 'The config show successfully',
                'data' => $data,
            ]
        );
    }

    public static function edit(Request $request, $uuid)
    {
        $key = $request->input('key', null);
        $description = $request->input('description', null);
        $value = $request->input('value', null);

        if ($key) {
            $userIds = User::getUidsInSameGroup($request->user);
            $count = DB::table('configs')->whereIn('user_id', $userIds)->where('key', $key)->where('uuid', '<>',
                $uuid)->count();
            if ($count) {
                return response()->json(config('tips.config.key.existing'));
            }
        }

        $model = DB::table('configs')->where('uuid', $uuid)->first();
        if (!$model) {
            return response()->json(config('tips.configs.empty'));
        }

        $model->permissionName = generatePermissionName(__CLASS__, __FUNCTION__);
        $hasPermission = User::hasPermission($request->user, $model);
        if (!$hasPermission) {
            return response()->json(config('tips.user.id.noPermission'));
        }

        $data = ['updated_at' => time()];
        if ($key) {
            $data['key'] = $key;
        }
        if ($description) {
            $data['description'] = $description;
        }
        if ($value) {
            $data['value'] = $value;
        }

        $result = DB::table('configs')->where('uuid', $uuid)->update($data);
        if (!$result) {
            return response()->json(config('tips.config.edit.failure'));
        }

        return response()->json([
            'code' => 0,
            'msg' => 'The config edit successfully',
            'data' => $data,
        ]);
    }

    public static function del(Request $request, $uuid)
    {
        $model = DB::table('configs')->where('uuid', $uuid)->first();
        if (!$model) {
            return response()->json(config('tips.config.empty'));
        }

        $model->permissionName = generatePermissionName(__CLASS__, __FUNCTION__);
        $hasPermission = User::hasPermission($request->user, $model, 1);
        if (!$hasPermission) {
            return response()->json(config('tips.user.id.noPermission'));
        }

        $result = DB::table('configs')->where('uuid', $uuid)->delete();
        if (!$result) {
            return response()->json(config('tips.config.delete.failure'));
        }

        return response()->json([
                'code' => 0,
                'msg' => 'The config delete successfully',
            ]
        );
    }
}
