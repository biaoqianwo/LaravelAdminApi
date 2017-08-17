<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductTag extends Model
{
    public static function index(Request $request)
    {
        $userId = $request->user->id;

        $datas = DB::table('product_tags')->whereIn('user_id', [0, $userId])->get();
        $count = DB::table('product_tags')->whereIn('user_id', [0, $userId])->count();
        if (!$count) {
            return response()->json(config('tips.productTags.empty'));
        }
        return response()->json([
                'code' => 0,
                'msg' => 'All products tags',
                'msg_zh' => '全部产品标签',
                'data' => $datas,
                'count' => $count,
            ]
        );
    }

    public static function store(Request $request)
    {
        $userId = $request->user->id;
        $name = $request->input('name', null);
        $values = $request->input('values', null);
        if (!$name) {
            return response()->json(config('tips.productTags.name.required'));
        }

        $count = DB::table('product_tags')->whereIn('user_id', [0, $userId])->where('name', $name)->count();
        if ($count) {
            return response()->json(config('tips.productTags.existing'));
        }

        $data = [
            'user_id' => $userId,
            'uuid' => iGenerateUuid(),
            'created_at' => time(),
            'name' => $name,
            'values' => $values,
            'updated_at' => time(),
        ];
        $id = DB::table('product_tags')->insertGetId($data);
        $data['id'] = $id;
        return response()->json([
            'code' => 0,
            'msg' => 'The product tags store successfully',
            'msg_zh' => '产品标签添加成功',
            'data' => $data,
        ]);
    }

    public static function show(Request $request, $uuid)
    {
        $userId = $request->user->id;

        $data = DB::table('product_tags')->whereIn('user_id', [0, $userId])->where('uuid', $uuid)->first();
        if (!$data) {
            return response()->json(config('tips.productTags.empty'));
        }

        return response()->json([
                'code' => 0,
                'msg' => 'The product tags show successfully',
                'msg_zh' => '产品标签查询成功',
                'data' => $data,
            ]
        );
    }

    public static function edit(Request $request, $uuid)
    {
        $userId = $request->user->id;
        $name = $request->input('name', null);
        $values = $request->input('values', null);
        if (!$name) {
            return response()->json(config('tips.productTags.name.required'));
        }

        $count = DB::table('product_tags')->whereIn('user_id', [0, $userId])->where('name', $name)->count();
        if ($count) {
            return response()->json(config('tips.productTags.existing'));
        }

        $data = [
            'name' => $name,
            'updated_at' => time(),
        ];
        if ($values) {
            $data = array_merge(['values' => $values], $data);
        }
        $result = DB::table('product_tags')->where('user_id', $userId)->where('uuid', $uuid)->update($data);
        if (!$result) {
            return response()->json(config('tips.productTags.edit.failure'));
        }
        return response()->json([
            'code' => 0,
            'msg' => 'The product tags edit successfully',
            'msg_zh' => '产品标签编辑成功',
            'data' => $data,
        ]);
    }

    public static function del(Request $request, $uuid)
    {
        $userId = $request->user->id;

        $result = DB::table('product_tags')->where('user_id', $userId)->where('uuid', $uuid)->delete();
        if (!$result) {
            return response()->json(config('tips.productTags.delete.failure'));
        }
        return response()->json([
                'code' => 0,
                'msg' => 'The product tags delete successfully',
                'msg_zh' => '产品标签删除成功',
            ]
        );
    }
}
