<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Article extends Model
{
    public static function index(Request $request, $offset = 0, $limit = 1000)
    {
        $userIds = User::getUidsInSameGroup($request->user);

        $count = DB::table('articles')->whereIn('user_id', $userIds)->count();
        if (!$count) {
            return response()->json(config('tips.article.empty'));
        }

        $datas = DB::table('articles')->whereIn('user_id', $userIds)->offset($offset)->limit($limit)->get();

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
        $name = $request->input('name', null);
        if (!$name) {
            return response()->json(config('tips.articleCate.name.required'));
        }

        $data = [
            'user_id' => $request->user->id,
            'uuid' => iGenerateUuid(),
            'name' => $name,
            'alias' => $request->input('alias', null),
            'article_cate_id' => $request->input('article_cate_id', 0),
            'tags' => $request->input('tags', null),
            'picture' => $request->input('picture', null),
            'url' => $request->input('url', null),
            'detail' => $request->input('detail', null),
            'click_num' => $request->input('click_num', 0),
            'status' => $request->input('status', 0),
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
        $data = DB::table('articles')->where('uuid', $uuid)->first();
        if (!$data) {
            return response()->json(config('tips.article.empty'));
        }

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
        $userId = $request->user->id;
        $request = $request->all();
        if (empty($request['name'])) {
            return response()->json(config('tips.article.name.required'));
        }

        $data = ['updated_at' => time()];

        if (!empty($request['name'])) {
            $data['name'] = $request['name'];
        }
        if (!empty($request['article_cate_id'])) {
            $data['article_cate_id'] = $request['article_cate_id'];
        }
        if (!empty($request['tags'])) {
            $data['tags'] = $request['tags'];
        }
        if (!empty($request['status'])) {
            $data['status'] = $request['status'];
        }

        $result = DB::table('articles')->where('user_id', $userId)->where('uuid', $uuid)->update($data);
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
        $userId = $request->user->id;

        $result = DB::table('articles')->where('user_id', $userId)->where('uuid', $uuid)->delete();
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
