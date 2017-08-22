<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Product extends Model
{
    public static function index(Request $request)
    {
        $userId = $request->user->id;
        $offset = $request->input('pos', 0);
        $limit = $request->input('count', 10);

        $datas = DB::table('products')->where('user_id', $userId)->offset($offset)->limit($limit)->get();
        $count = 1;//默认有数据
        if ($offset == 0) {
            $count = DB::table('products')->where('user_id', $userId)->count();
        }
        if (!$count) {
            return response()->json(config('tips.product.empty'));
        }
        return response()->json([
                'code' => 0,
                'msg' => 'The products from ' . $offset . ',len ' . $limit,
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
            return response()->json(config('tips.product.name.required'));
        }

        if (!empty($request['code'])) {
            $count = DB::table('products')->where('user_id', $userId)->where('code', $request['code'])->count();
            if ($count) {
                return response()->json(config('tips.product.existing'));
            }
        }

        $data = [
            'user_id' => $userId,
            'uuid' => iGenerateUuid(),
            'created_at' => time(),
            'name' => $request['name'],
            'code' => $request['code'],
            'attrs' => !empty($request['attrs']) ? $request['attrs'] : null,
            'tags' => !empty($request['tags']) ? $request['tags'] : null,
            'status' => !empty($request['status']) ? $request['status'] : 0,
            'updated_at' => time(),
            //todo 更多字段...
        ];
        $id = DB::table('products')->insertGetId($data);
        $data['id'] = $id;
        return response()->json([
            'code' => 0,
            'msg' => 'The product store successfully',
            'data' => $data,
        ]);
    }

    public static function show(Request $request, $uuid)
    {
        $userId = $request->user->id;

        $data = DB::table('products')->where('user_id', $userId)->where('uuid', $uuid)->first();
        if (!$data) {
            return response()->json(config('tips.product.empty'));
        }
        return response()->json([
                'code' => 0,
                'msg' => 'The product show successfully',
                'data' => $data,
            ]
        );
    }

    public static function edit(Request $request, $uuid)
    {
        $userId = $request->user->id;
        $request = $request->all();
        if (empty($request['name'])) {
            return response()->json(config('tips.product.name.required'));
        }

        //todo 非添加者应该可以操作(多用户)

        if (!empty($request['code'])) {

            $count = DB::table('products')->where('user_id', $userId)->where('code', $request['code'])->count();
            if ($count) {
                return response()->json(config('tips.product.existing'));
            }
        }

        $data = ['updated_at' => time()];
        if (!empty($request['name'])) {
            $data['name'] = $request['name'];
        }
        if (!empty($request['code'])) {
            $data['code'] = $request['code'];
        }
        if (!empty($request['attrs'])) {
            $data['attrs'] = $request['attrs'];
        }
        if (!empty($request['tags'])) {
            $data['tags'] = $request['tags'];
        }
        if (!empty($request['status'])) {
            $data['status'] = $request['status'];
        }
        //todo 更多字段...

        $result = DB::table('products')->where('user_id', $userId)->where('uuid', $uuid)->update($data);
        if (!$result) {
            return response()->json(config('tips.product.edit.failure'));
        }
        return response()->json([
            'code' => 0,
            'msg' => 'The product edit successfully',
            'data' => $data,
        ]);
    }

    public static function del(Request $request, $uuid)
    {
        $userId = $request->user->id;

        $result = DB::table('products')->where('user_id', $userId)->where('uuid', $uuid)->delete();
        if (!$result) {
            return response()->json(config('tips.product.delete.failure'));
        }
        return response()->json([
                'code' => 0,
                'msg' => 'The product delete successfully',
            ]
        );
    }
}
