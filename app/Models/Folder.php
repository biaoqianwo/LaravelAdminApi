<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Folder extends Model
{
    public static function store(Request $request)
    {
        $userId = $request->user->id;

        $folder = $request->input('folder');
        $folder = self::formatFolder($folder);
        if (!iValidateString($folder, 'folder')) {
            return response()->json(config('tips.folder.format'));
        }

        $result = DB::table('files')->where('user_id', $userId)->where('folder', $folder)->count();
        if ($result) {
            return response()->json(config('tips.folder.existing'));
        }

        $data = [
            'user_id' => $userId,
            'uuid' => iGenerateUuid(),
            'folder' => $folder,
            'used_num' => 0,
            'created_at' => time(),
            'updated_at' => time(),
        ];
        DB::table('files')->insertGetId($data);
        return response()->json([
            'code' => 0,
            'msg' => 'The file store successfully',
            'data' => $data,
        ]);
    }

    public static function edit(Request $request, $uuid)
    {
        $userId = $request->user->id;

        $folder = $request->input('folder');
        $folder = self::formatFolder($folder);
        if (!iValidateString($folder, 'folder')) {
            return response()->json(config('tips.folder.format'));
        }

        $result = DB::table('files')->where('user_id', $userId)->where('folder', $folder)->count();
        if ($result) {
            return response()->json(config('tips.folder.existing'));
        }

        $result = DB::table('files')->where('user_id', $userId)->where('uuid',
            $uuid)->update(['folder' => $folder]);
        if (!$result) {
            return response()->json(config('tips.folder.edit.failure'));
        }
        return response()->json([
            'code' => 0,
            'msg' => 'The file edit successfully',
        ]);
    }

    /**
     * 给文件夹首位添加斜线/
     * @param $folder
     * @return string
     */
    public static function formatFolder($folder)
    {
        $folder = !starts_with($folder, '/') ? '/' . $folder : $folder;
        $folder = !ends_with($folder, '/') ? $folder . '/' : $folder;
        return $folder;
    }

    public static function del(Request $request, $uuid)
    {
        $userId = $request->user->id;

        // todo 嵌套查询...
        $folder = DB::table('files')->where('user_id', $userId)->where('uuid', $uuid)->value('folder');
        $result = DB::table('files')->where('user_id', $userId)->where('folder', $folder)->count();
        if ($result > 1) {
            return response()->json(config('tips.folder.delete.existFiles'));
        }

        $result = DB::table('files')->where('user_id', $userId)->where('uuid', $uuid)->delete();
        if (!$result) {
            return response()->json(config('tips.folder.delete.failure'));
        }
        return response()->json([
                'code' => 0,
                'msg' => 'The folder delete successfully',
            ]
        );
    }
}
