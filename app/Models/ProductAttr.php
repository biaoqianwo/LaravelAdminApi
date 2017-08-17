<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductAttr extends Model
{
    public static function index(Request $request)
    {
        $userId = $request->user->id;

        $datas = DB::table('product_attrs')->whereIn('user_id', [0, $userId])->get();
        $count = DB::table('product_attrs')->whereIn('user_id', [0, $userId])->count();
        if (!$count) {
            return response()->json(config('tips.productAttrs.empty'));
        }
        return response()->json([
                'code' => 0,
                'msg' => 'All products attrs',
                'msg_zh' => '全部产品属性',
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
            return response()->json(config('tips.productAttrs.name.required'));
        }

        $count = DB::table('product_attrs')->whereIn('user_id', [0, $userId])->where('name', $name)->count();
        if ($count) {
            return response()->json(config('tips.productAttrs.existing'));
        }

        $data = [
            'user_id' => $userId,
            'uuid' => iGenerateUuid(),
            'created_at' => time(),
            'name' => $name,
            'updated_at' => time(),
        ];
        $id = DB::table('product_attrs')->insertGetId($data);
        $data['id'] = $id;
        return response()->json([
            'code' => 0,
            'msg' => 'The product attrs store successfully',
            'msg_zh' => '产品属性添加成功',
            'data' => $data,
        ]);
    }

    public static function show(Request $request, $uuid)
    {
        $userId = $request->user->id;

        $data = DB::table('product_attrs')->whereIn('user_id', [0, $userId])->where('uuid', $uuid)->first();
        if (!$data) {
            return response()->json(config('tips.productAttrs.empty'));
        }

        return response()->json([
                'code' => 0,
                'msg' => 'The product attrs show successfully',
                'msg_zh' => '产品属性查询成功',
                'data' => $data,
            ]
        );
    }

    public static function edit(Request $request, $uuid)
    {
        $userId = $request->user->id;
        $name = $request->input('name', null);
        if (!$name) {
            return response()->json(config('tips.productAttrs.name.required'));
        }

        $count = DB::table('product_attrs')->whereIn('user_id', [0, $userId])->where('name', $name)->count();
        if ($count) {
            return response()->json(config('tips.productAttrs.existing'));
        }

        $data = [
            'name' => $name,
            'updated_at' => time(),
        ];
        $result = DB::table('product_attrs')->where('user_id', $userId)->where('uuid', $uuid)->update($data);
        if (!$result) {
            return response()->json(config('tips.productAttrs.edit.failure'));
        }
        return response()->json([
            'code' => 0,
            'msg' => 'The product attrs edit successfully',
            'msg_zh' => '产品属性编辑成功',
            'data' => $data,
        ]);
    }

    public static function del(Request $request, $uuid)
    {
        $userId = $request->user->id;

        $result = DB::table('product_attrs')->where('user_id', $userId)->where('uuid', $uuid)->delete();
        if (!$result) {
            return response()->json(config('tips.productAttrs.delete.failure'));
        }
        return response()->json([
                'code' => 0,
                'msg' => 'The product attrs delete successfully',
                'msg_zh' => '产品属性删除成功',
            ]
        );
    }
}
