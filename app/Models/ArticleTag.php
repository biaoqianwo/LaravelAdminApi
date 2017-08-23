<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ArticleTag extends Model
{
    public static function index(Request $request, $offset = 0, $limit = 1000)
    {
        $hasPermission = User::hasPermission($request->user, generatePermissionName(__CLASS__, __FUNCTION__));
        if (!$hasPermission) {
            return response()->json(config('tips.user.id.noPermission'));
        }

        $userIds = User::getUidsInSameGroup($request->user);

        $count = DB::table('article_tags')->whereIn('user_id', $userIds)->count();
        if (!$count) {
            return response()->json(config('tips.articleTag.empty'));
        }

        $datas = DB::table('article_tags')->whereIn('user_id', $userIds)->offset($offset)->limit($limit)->get();

        return response()->json([
                'code' => 0,
                'msg' => 'The article tag from ' . $offset . ',len ' . $limit,
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
            return response()->json(config('tips.articleTag.name.required'));
        }

        $userIds = User::getUidsInSameGroup($request->user);
        $count = DB::table('article_tags')->whereIn('user_id', $userIds)->where('name', $name)->count();
        if ($count) {
            return response()->json(config('tips.articleTag.existing'));
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
            'status' => $request->input('status', 1),
            'created_at' => time(),
            'updated_at' => time(),
        ];
        DB::table('article_tags')->insertGetId($data);

        return response()->json([
            'code' => 0,
            'msg' => 'The article tag store successfully',
            'data' => $data,
        ]);
    }

    public static function show(Request $request, $uuid)
    {
        $userIds = User::getUidsInSameGroup($request->user);
        $data = DB::table('article_tags')->where('uuid', $uuid)->first();
        if (!$data) {
            return response()->json(config('tips.articleTag.empty'));
        }

        $data->permissionName = generatePermissionName(__CLASS__, __FUNCTION__);
        $hasPermission = User::hasPermission($request->user, $data);
        if (!$hasPermission) {
            return response()->json(config('tips.user.id.noPermission'));
        }
        unset($data->permissionName);

        return response()->json([
                'code' => 0,
                'msg' => 'The article tag show successfully',
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
        $status = $request->input('status', -1);
        if (!$name) {
            return response()->json(config('tips.articleTag.name.required'));
        }

        $userIds = User::getUidsInSameGroup($request->user->group);
        $count = DB::table('article_tags')->whereIn('user_id', $userIds)->where('name', $name)->count();
        if ($count) {
            return response()->json(config('tips.articleTag.existing'));
        }

        $model = DB::table('article_tags')->where('uuid', $uuid)->first();
        $model->permissionName = generatePermissionName(__CLASS__, __FUNCTION__);
        $hasPermission = User::hasPermission($request->user, $model);
        if (!$hasPermission) {
            return response()->json(config('tips.user.id.noPermission'));
        }

        $data = ['updated_at' => time()];
        if (!$name) {
            $data['name'] = $name;
        }
        if (!$color) {
            $data['color'] = $color;
        }
        if (!$icon) {
            $data['icon'] = $icon;
        }
        if (!$poster) {
            $data['poster'] = $poster;
        }
        if (!$intro) {
            $data['intro'] = $intro;
        }
        if (!$keywords) {
            $data['keywords'] = $keywords;
        }
        if (!$description) {
            $data['description'] = $description;
        }
        if ($status >= 0) {
            $data['status'] = $status;
        }

        $result = DB::table('article_tags')->where('uuid', $uuid)->update($data);
        if (!$result) {
            return response()->json(config('tips.articleTag.edit.failure'));
        }

        return response()->json([
            'code' => 0,
            'msg' => 'The article tag edit successfully',
            'data' => $data,
        ]);
    }

    public static function del(Request $request, $uuid)
    {
        $model = DB::table('article_tags')->where('uuid', $uuid)->first();
        $model->permissionName = generatePermissionName(__CLASS__, __FUNCTION__);
        $hasPermission = User::hasPermission($request->user, $model, 1);
        if (!$hasPermission) {
            return response()->json(config('tips.user.id.noPermission'));
        }

        $result = DB::table('article_tags')->where('uuid', $uuid)->delete();
        if (!$result) {
            return response()->json(config('tips.articleTag.delete.failure'));
        }

        return response()->json([
                'code' => 0,
                'msg' => 'The article tag delete successfully',
            ]
        );
    }
}
