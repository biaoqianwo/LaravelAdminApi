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
            return response()->json(config('tips.productTag.empty'));
        }
        return response()->json([
                'code' => 0,
                'msg' => 'All product tags',
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
            return response()->json(config('tips.productTag.name.required'));
        }

        $count = DB::table('product_tags')->whereIn('user_id', [0, $userId])->where('name', $name)->count();
        if ($count) {
            return response()->json(config('tips.productTag.existing'));
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
            'data' => $data,
        ]);
    }

    public static function show(Request $request, $uuid)
    {
        $userId = $request->user->id;

        $data = DB::table('product_tags')->whereIn('user_id', [0, $userId])->where('uuid', $uuid)->first();
        if (!$data) {
            return response()->json(config('tips.productTag.empty'));
        }

        return response()->json([
                'code' => 0,
                'msg' => 'The product tags show successfully',
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
            return response()->json(config('tips.productTag.name.required'));
        }

        $count = DB::table('product_tags')->whereIn('user_id', [0, $userId])->where('name', $name)->count();
        if ($count) {
            return response()->json(config('tips.productTag.existing'));
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
            return response()->json(config('tips.productTag.edit.failure'));
        }
        return response()->json([
            'code' => 0,
            'msg' => 'The product tags edit successfully',
            'data' => $data,
        ]);
    }

    public static function del(Request $request, $uuid)
    {
        $userId = $request->user->id;

        $result = DB::table('product_tags')->where('user_id', $userId)->where('uuid', $uuid)->delete();
        if (!$result) {
            return response()->json(config('tips.productTag.delete.failure'));
        }
        return response()->json([
                'code' => 0,
                'msg' => 'The product tags delete successfully',
            ]
        );
    }
}
