<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Article extends Model
{
    public static function index(Request $request)
    {
        $userId = $request->user->id;
        $offset = $request->input('pos', 0);
        $limit = $request->input('count', 10);

        $datas = DB::table('articles')->where('user_id', $userId)->offset($offset)->limit($limit)->get();
        $count = 1;//默认有数据
        if ($offset == 0) {
            $count = DB::table('articles')->where('user_id', $userId)->count();
        }
        if (!$count) {
            return response()->json(config('tips.article.empty'));
        }
        return response()->json([
                'code' => 0,
                'msg' => 'The articles from ' . $offset . ',len ' . $limit,
                'data' => $datas,
                'count' => $count,
            ]
        );
    }

    public static function store(Request $request)
    {
        $userId = $request->user->id;
        $request = $request->all();
        if (empty($request['name'])) {
            return response()->json(config('tips.article.name.required'));
        }
//        $count = DB::table('articles')->where('user_id', $userId)->where('name', $request['name'])->count();
//        if ($count) {
//            return response()->json(config('tips.article.existing'));
//        }

        $data = [
            'user_id' => $userId,
            'uuid' => iGenerateUuid(),
            'created_at' => time(),
            'name' => $request['name'],
            'article_cate_id' => !empty($request['article_cate_id']) ? $request['article_cate_id'] : 0,
            'tags' => !empty($request['tags']) ? $request['tags'] : null,
            'status' => !empty($request['status']) ? $request['status'] : 0,
            'updated_at' => time(),
            //todo 更多字段...
        ];
        $id = DB::table('articles')->insertGetId($data);
        $data['id'] = $id;
        return response()->json([
            'code' => 0,
            'msg' => 'The article store successfully',
            'data' => $data,
        ]);
    }

    public static function show(Request $request, $uuid)
    {
        $userId = $request->user->id;

        $data = DB::table('articles')->where('user_id', $userId)->where('uuid', $uuid)->first();
        if (!$data) {
            return response()->json(config('tips.article.empty'));
        }
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

        //todo 非添加者应该可以操作(多用户)

//        $count = DB::table('articles')->where('user_id', $userId)->where('name', $request['name'])->count();
//        if ($count) {
//            return response()->json(config('tips.article.existing'));
//        }

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
        // todo 更多字段...

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
