<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Article2 extends Model
{
    public static function index(Request $request, $offset = 0, $limit = 100)
    {
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

    public static function show(Request $request, $uuid)
    {
        $userIds = User::getUidsInSameGroup($request->user);

        $data = DB::table('articles')->whereIn('user_id', $userIds)->where('uuid', $uuid)->first();
        if (!$data) {
            return response()->json(config('tips.article.empty'));
        }
        $parsedown = new \Parsedown();
        $data->html = $parsedown->text($data->detail);

        return response()->json([
                'code' => 0,
                'msg' => 'The article show successfully',
                'data' => $data,
            ]
        );
    }
}
