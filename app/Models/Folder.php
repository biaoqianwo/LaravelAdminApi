<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Folder extends Model
{
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

    public static function store(Request $request)
    {
        $hasPermission = User::hasPermission($request->user, generatePermissionName(__CLASS__, __FUNCTION__));
        if (!$hasPermission) {
            return response()->json(config('tips.user.id.noPermission'));
        }

        $folder = $request->input('folder', null);
        $folder = self::formatFolder($folder);
        if (!iValidateString($folder, 'folder')) {
            return response()->json(config('tips.folder.format'));
        }

        $userIds = User::getUidsInSameGroup($request->user);
        $result = DB::table('files')->whereIn('user_id', $userIds)->where('folder', $folder)->count();
        if ($result) {
            return response()->json(config('tips.folder.existing'));
        }

        $data = [
            'user_id' => $request->user->id,
            'uuid' => iGenerateUuid(),
            'folder' => $folder,
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
        $folder = $request->input('folder');
        $folder = self::formatFolder($folder);
        if (!iValidateString($folder, 'folder')) {
            return response()->json(config('tips.folder.format'));
        }

        $userIds = User::getUidsInSameGroup($request->user);
        $result = DB::table('files')->whereIn('user_id', $userIds)->where('folder', $folder)->count();
        if ($result) {
            return response()->json(config('tips.folder.existing'));
        }

        $model = DB::table('files')->where('uuid', $uuid)->first();
        $model->permissionName = generatePermissionName(__CLASS__, __FUNCTION__);
        $hasPermission = User::hasPermission($request->user, $model);
        if (!$hasPermission) {
            return response()->json(config('tips.user.id.noPermission'));
        }

        $result = DB::table('files')->where('uuid', $uuid)->update(['folder' => $folder]);
        if (!$result) {
            return response()->json(config('tips.folder.edit.failure'));
        }

        return response()->json([
            'code' => 0,
            'msg' => 'The file edit successfully',
        ]);
    }

    public static function del(Request $request, $uuid)
    {
        $result = DB::table('files')->where('uuid', $uuid)->whereNotNull('name')->count();
        if ($result) {
            return response()->json(config('tips.folder.delete.existFiles'));
        }

        $model = DB::table('files')->where('uuid', $uuid)->first();
        $model->permissionName = generatePermissionName(__CLASS__, __FUNCTION__);
        $hasPermission = User::hasPermission($request->user, $model, 1);
        if (!$hasPermission) {
            return response()->json(config('tips.user.id.noPermission'));
        }

        $result = DB::table('files')->where('uuid', $uuid)->delete();
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
