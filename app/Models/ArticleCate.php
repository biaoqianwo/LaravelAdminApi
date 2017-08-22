<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ArticleCate extends Model
{
    public static function index(Request $request)
    {
        $userId = $request->user->id;

        $datas = DB::table('article_cates')->whereIn('user_id', [0, $userId])->get();
        $count = DB::table('article_cates')->whereIn('user_id', [0, $userId])->count();
        if (!$count) {
            return response()->json(config('tips.articleCate.empty'));
        }
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

        $count = DB::table('article_cates')->whereIn('user_id', [0, $userId])->where('name', $name)->count();
        if ($count) {
            return response()->json(config('tips.articleCate.existing'));
        }

        $data = [
            'user_id' => $userId,
            'uuid' => iGenerateUuid(),
            'created_at' => time(),
            'name' => $name,
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
        $userId = $request->user->id;

        $data = DB::table('article_cates')->whereIn('user_id', [0, $userId])->where('uuid', $uuid)->first();
        if (!$data) {
            return response()->json(config('tips.articleCate.empty'));
        }

        return response()->json([
                'code' => 0,
                'msg' => 'The article cate show successfully',
                'data' => $data,
            ]
        );
    }

    public static function edit(Request $request, $uuid)
    {
        $userId = $request->user->id;
        $name = $request->input('name', null);
        if (!$name) {
            return response()->json(config('tips.articleCate.name.required'));
        }

        $count = DB::table('article_cates')->whereIn('user_id', [0, $userId])->where('name', $name)->count();
        if ($count) {
            return response()->json(config('tips.articleCate.existing'));
        }

        $data = [
            'name' => $name,
            'updated_at' => time(),
        ];
        $result = DB::table('article_cates')->where('user_id', $userId)->where('uuid', $uuid)->update($data);
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
        $userId = $request->user->id;

        $result = DB::table('article_cates')->where('user_id', $userId)->where('uuid', $uuid)->delete();
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
