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
 * 验证顺序：先字段，再权限
 * Class ArticleCate
 * @package App\Models
 */
class ArticleCate extends Model
{
    public static function index(Request $request, $offset = 0, $limit = 100)
    {
        $hasPermission = User::hasPermission($request->user, generatePermissionName(__CLASS__, __FUNCTION__));
        if (!$hasPermission) {
            return response()->json(config('tips.user.id.noPermission'));
        }

        $userIds = User::getUidsInSameGroup($request->user);

        $count = DB::table('article_cates')->whereIn('user_id', $userIds)->count();
        if (!$count) {
            return response()->json(config('tips.articleCate.empty'));
        }

        $datas = DB::table('article_cates')->whereIn('user_id', $userIds)->offset($offset)->limit($limit)->get();

        return response()->json([
                'code' => 0,
                'msg' => 'The article cate from ' . $offset . ',len ' . $limit,
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
            return response()->json(config('tips.articleCate.name.required'));
        }

        $userIds = User::getUidsInSameGroup($request->user);
        $count = DB::table('article_cates')->whereIn('user_id', $userIds)->where('name', $name)->count();
        if ($count) {
            return response()->json(config('tips.articleCate.existing'));
        }

        $data = [
            'uuid' => iGenerateUuid(),
            'user_id' => $request->user->id,
            'name' => $name,
            'color' => $request->input('color', null),
            'icon' => $request->input('icon', null),
            'poster' => $request->input('poster', null),
            'intro' => $request->input('intro', null),
            'keywords' => $request->input('keywords', null),
            'description' => $request->input('description', null),
            'status' => (int)$request->input('status', 1),
            'created_at' => time(),
            'updated_at' => time(),
        ];
        DB::table('article_cates')->insertGetId($data);

        return response()->json([
            'code' => 0,
            'msg' => 'The article cate store successfully',
            'data' => $data,
        ]);
    }

    public static function show(Request $request, $uuid)
    {
        $userIds = User::getUidsInSameGroup($request->user);

        $data = DB::table('article_cates')->whereIn('user_id', $userIds)->where('uuid', $uuid)->first();
        if (!$data) {
            return response()->json(config('tips.articleCate.empty'));
        }

        $data->permissionName = generatePermissionName(__CLASS__, __FUNCTION__);
        $hasPermission = User::hasPermission($request->user, $data);
        if (!$hasPermission) {
            return response()->json(config('tips.user.id.noPermission'));
        }
        unset($data->permissionName);

        return response()->json([
                'code' => 0,
                'msg' => 'The article cate show successfully',
                'data' => $data,
            ]
        );
    }

    public static function edit(Request $request, $uuid)
    {
        $name = $request->input('name', null);
        $color = $request->input('color', null);
        $icon = $request->input('icon', null);
        $poster = $request->input('poster', null);
        $intro = $request->input('intro', null);
        $keywords = $request->input('keywords', null);
        $description = $request->input('description', null);
        $status = (int)$request->input('status', -1);

        if ($name) {
            $userIds = User::getUidsInSameGroup($request->user);
            $count = DB::table('article_cates')->whereIn('user_id', $userIds)->where('name', $name)->where('uuid', '<>',
                $uuid)->count();
            if ($count) {
                return response()->json(config('tips.articleCate.existing'));
            }
        }

        $model = DB::table('article_cates')->where('uuid', $uuid)->first();
        if (!$model) {
            return response()->json(config('tips.articleCate.empty'));
        }

        $model->permissionName = generatePermissionName(__CLASS__, __FUNCTION__);
        $hasPermission = User::hasPermission($request->user, $model);
        if (!$hasPermission) {
            return response()->json(config('tips.user.id.noPermission'));
        }

        $data = ['updated_at' => time()];
        if ($name) {
            $data['name'] = $name;
        }
        if ($color) {
            $data['color'] = $color;
        }
        if ($icon) {
            $data['icon'] = $icon;
        }
        if ($poster) {
            $data['poster'] = $poster;
        }
        if ($intro) {
            $data['intro'] = $intro;
        }
        if ($keywords) {
            $data['keywords'] = $keywords;
        }
        if ($description) {
            $data['description'] = $description;
        }
        if ($status >= 0) {
            $data['status'] = $status;
        }

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
        if (!$model) {
            return response()->json(config('tips.articleCate.empty'));
        }

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
