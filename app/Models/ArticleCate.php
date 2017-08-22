<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * index：查看同一个组的所有记录
 * store：保存
 * show：查看同一个组的某个记录
 * edit：超级管理员和自己可以操作
 * del：超级管理员
 * Class ArticleCate
 * @package App\Models
 */
class ArticleCate extends Model
{
    public static function index(Request $request)
    {
        $userIds = User::getUidsByGroup($request->user);
        $count = DB::table('article_cates')->whereIn('user_id', $userIds)->count();
        if (!$count) {
            return response()->json(config('tips.articleCate.empty'));
        }
        $datas = DB::table('article_cates')->whereIn('user_id', $userIds)->get();
        return response()->json([
                'code' => 0,
                'msg' => 'All article cates',
                'data' => $datas,
                'count' => $count,
            ]
        );
    }

    public static function store(Request $request)
    {
        $userId = $request->user->id;
        $name = $request->input('name', null);
        if (!$name) {
            return response()->json(config('tips.articleCate.name.required'));
        }

        $userIds = User::getUidsByGroup($request->user);
        $count = DB::table('article_cates')->whereIn('user_id', $userIds)->where('name', $name)->count();
        if ($count) {
            return response()->json(config('tips.articleCate.existing'));
        }

        $data = [
            'uuid' => iGenerateUuid(),
            'user_id' => $userId,
            'name' => $name,
            'color' => $request->input('color', null),
            'icon' => $request->input('icon', null),
            'poster' => $request->input('poster', null),
            'intro' => $request->input('intro', null),
            'keywords' => $request->input('keywords', null),
            'description' => $request->input('description', null),
            'status' => $request->input('status', 1),
            'created_at' => time(),
            'updated_at' => time(),
        ];
        $id = DB::table('article_cates')->insertGetId($data);
        $data['id'] = $id;
        return response()->json([
            'code' => 0,
            'msg' => 'The article cate store successfully',
            'data' => $data,
        ]);
    }

    public static function show(Request $request, $uuid)
    {
        $model = DB::table('article_cates')->where('uuid', $uuid)->first();
        if (!$model) {
            return response()->json(config('tips.articleCate.empty'));
        }

        $model->permissionName = generatePermissionName(__CLASS__, __FUNCTION__);
        $hasPermission = User::hasPermission($request->user, $model);
        if (!$hasPermission) {
            return response()->json(config('tips.user.id.noPermission'));
        }

        unset($model->permissionName);
        return response()->json([
                'code' => 0,
                'msg' => 'The article cate show successfully',
                'data' => $model,
            ]
        );
    }

    public static function edit(Request $request, $uuid)
    {
        $model = DB::table('article_cates')->where('uuid', $uuid)->first();
        $model->permissionName = generatePermissionName(__CLASS__, __FUNCTION__);
        $hasPermission = User::hasPermission($request->user, $model);
        if (!$hasPermission) {
            return response()->json(config('tips.user.id.noPermission'));
        }

        $name = $request->input('name', null);
        if (!$name) {
            return response()->json(config('tips.articleCate.name.required'));
        }

        $userIds = User::getUidsByGroup($request->user->group);
        $count = DB::table('article_cates')->whereIn('user_id', $userIds)->where('name', $name)->count();
        if ($count) {
            return response()->json(config('tips.articleCate.existing'));
        }

        $data = [
            'name' => $name,
            'updated_at' => time(),
        ];
        $result = DB::table('article_cates')->where('uuid', $uuid)->update($data);
        if (!$result) {
            return response()->json(config('tips.articleCate.edit.failure'));
        }
        return response()->json([
            'code' => 0,
            'msg' => 'The article cate edit successfully',
            'data' => $data,
        ]);
    }

    public static function del(Request $request, $uuid)
    {
        $model = DB::table('article_cates')->where('uuid', $uuid)->first();
        $model->permissionName = generatePermissionName(__CLASS__, __FUNCTION__);
        $hasPermission = User::hasPermission($request->user, $model, 1);
        if (!$hasPermission) {
            return response()->json(config('tips.user.id.noPermission'));
        }

        $result = DB::table('article_cates')->where('uuid', $uuid)->delete();
        if (!$result) {
            return response()->json(config('tips.articleCate.delete.failure'));
        }
        return response()->json([
                'code' => 0,
                'msg' => 'The article cate delete successfully',
            ]
        );
    }
}
