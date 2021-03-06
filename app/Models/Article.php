<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Article extends Model
{
    public static function index(Request $request, $offset = 0, $limit = 100)
    {
        $hasPermission = User::hasPermission($request->user, generatePermissionName(__CLASS__, __FUNCTION__));
        if (!$hasPermission) {
            return response()->json(config('tips.user.id.noPermission'));
        }

        $userIds = User::getUidsInSameGroup($request->user);

        // todo 缓存
        $count = DB::table('articles')->whereIn('user_id', $userIds)->count();
        if (!$count) {
            return response()->json(config('tips.article.empty'));
        }

        $datas = DB::table('articles')->whereIn('user_id', $userIds)->offset($offset)->limit($limit)->orderBy('id',
            'desc')->get();
        foreach ($datas as $data) {
            $parsedown = new \Parsedown();
            $data->html = str_limit(strip_tags($parsedown->text($data->detail)), 280);
            $data->dateFormat = date('Y-m-d H:i:s', $data->updated_at);
        }

        return response()->json([
                'code' => 0,
                'msg' => 'The article from ' . $offset . ',len ' . $limit,
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
            return response()->json(config('tips.article.name.required'));
        }

        $data = [
            'user_id' => $request->user->id,
            'uuid' => iGenerateUuid(),
            'name' => $name,
            'alias' => $request->input('alias', null),
            'article_cate_id' => (int)$request->input('article_cate_id', 0),
            'tags' => $request->input('tags', null),
            'picture' => $request->input('picture', null),
            'url' => $request->input('url', null),
            'detail' => $request->input('detail', null),
            'click_num' => (int)$request->input('click_num', 0),
            'status' => (int)$request->input('status', 1),
            'created_at' => time(),
            'updated_at' => time(),
        ];
        DB::table('articles')->insertGetId($data);

        return response()->json([
            'code' => 0,
            'msg' => 'The article store successfully',
            'data' => $data,
        ]);
    }

    public static function show(Request $request, $uuid)
    {
        $userIds = User::getUidsInSameGroup($request->user);

        $data = DB::table('articles')->whereIn('user_id', $userIds)->where('uuid', $uuid)->first();
        if (!$data) {
            return response()->json(config('tips.article.empty'));
        }
        $parsedown = new \Parsedown();
        $data->html = $parsedown->text($data->detail);

        $data->permissionName = generatePermissionName(__CLASS__, __FUNCTION__);
        $hasPermission = User::hasPermission($request->user, $data);
        if (!$hasPermission) {
            return response()->json(config('tips.user.id.noPermission'));
        }
        unset($data->permissionName);

        return response()->json([
                'code' => 0,
                'msg' => 'The article show successfully',
                'data' => $data,
            ]
        );
    }

    public static function edit(Request $request, $uuid)
    {
        $name = $request->input('name', null);
        if (!$name) {
            return response()->json(config('tips.article.name.required'));
        }

        $model = DB::table('articles')->where('uuid', $uuid)->first();
        if (!$model) {
            return response()->json(config('tips.article.empty'));
        }
        $model->permissionName = generatePermissionName(__CLASS__, __FUNCTION__);
        $hasPermission = User::hasPermission($request->user, $model);
        if (!$hasPermission) {
            return response()->json(config('tips.user.id.noPermission'));
        }

        $data = [
            'name' => $name,
            'alias' => $request->input('alias', null),
            'article_cate_id' => (int)$request->input('article_cate_id', 0),
            'tags' => $request->input('tags', null),
            'picture' => $request->input('picture', null),
            'url' => $request->input('url', null),
            'detail' => $request->input('detail', null),
            'click_num' => (int)$request->input('click_num', 0),
            'status' => (int)$request->input('status', 1),
            'updated_at' => time(),
        ];

        $result = DB::table('articles')->where('uuid', $uuid)->update($data);
        if (!$result) {
            return response()->json(config('tips.article.edit.failure'));
        }

        return response()->json([
            'code' => 0,
            'msg' => 'The article edit successfully',
            'data' => $data,
        ]);
    }

    public static function del(Request $request, $uuid)
    {
        $model = DB::table('articles')->where('uuid', $uuid)->first();
        if (!$model) {
            return response()->json(config('tips.article.empty'));
        }

        $model->permissionName = generatePermissionName(__CLASS__, __FUNCTION__);
        $hasPermission = User::hasPermission($request->user, $model, 1);
        if (!$hasPermission) {
            return response()->json(config('tips.user.id.noPermission'));
        }

        $result = DB::table('articles')->where('uuid', $uuid)->delete();
        if (!$result) {
            return response()->json(config('tips.article.delete.failure'));
        }

        return response()->json([
                'code' => 0,
                'msg' => 'The article delete successfully',
            ]
        );
    }
}
