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
        $name = $request->input('name');
        $code = $request->input('code');
        if (!$name) {
            return response()->json(config('tips.product.name.required'));
        }

        if (!empty($request['code'])) {
            $count = DB::table('products')->where('user_id', $userId)->where('code', $code)->count();
            if ($count) {
                return response()->json(config('tips.product.existing'));
            }
        }
        $data = [
            'user_id' => $userId,
            'uuid' => iGenerateUuid(),
            'code' => $code,
            'name' => $name,
            'attrs' => $request->input('attrs', null),
            'alias' => $request->input('alias', null),
            'picture' => $request->input('picture', null),
            'params' => $request->input('params', null),
            'url' => $request->input('url', null),
            'detail' => $request->input('detail', null),
            'status' => $request->input('status', 1),
            'created_at' => time(),
            'updated_at' => time(),
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
        if (!empty($request['code'])) {
            $data['code'] = $request['code'];
        }
        if (!empty($request['name'])) {
            $data['name'] = $request['name'];
        }
        if (!empty($request['alias'])) {
            $data['alias'] = $request['alias'];
        }
        if (!empty($request['attrs'])) {
            $data['attrs'] = $request['attrs'];
        }
        if (!empty($request['params'])) {
            $data['params'] = $request['params'];
        }
        if (!empty($request['url'])) {
            $data['url'] = $request['url'];
        }
        if (!empty($request['detail'])) {
            $data['detail'] = $request['detail'];
        }
        if (!empty($request['status'])) {
            $data['status'] = $request['status'];
        }

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
