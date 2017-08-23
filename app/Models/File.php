<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;

//use Intervention\Image\ImageManagerStatic as Image;

class File extends Model
{

    /**
     * 上传单个文件
     * @param UploadedFile $file
     * @param Request $request
     * @return array
     */
    private static function storeFileBasic(UploadedFile $file, Request $request)
    {
        $uuid = iGenerateUuid();

        $folder = $request->input('folder', '/');
        $folder = Folder::formatFolder($folder);
        //校验文件：大小，宽高，格式等限制
        //iCheckFile($file);
        //or
        //$image = Image::make($file);
        //$image->width(),$image->height(),$image->filesize(),$file->getClientOriginalExtension(),$image->mime();

        //上传到服务器（屋里地址固定）
        $dir = $request->user->group;
        $name = $uuid . '.' . $file->getClientOriginalExtension();
        $size = $file->getSize();
        $file->storeAs('public/' . $dir . '/', $name);

        //物理地址:storage/app/public/为根
        //or
        //$in = storage_path('app/public/' . $uuid . '/' . $name);//需要事先生成文件夹
        //$image->save($in);

        //缩略图
        //$image->resize(300, 300)->save($in . '_300_300.jpg');
        //保存记录到数据库

        $data = [
            'user_id' => $request->user->id,
            'uuid' => $uuid,
            'folder' => $folder,
            'name' => $name,
            'size' => $size,
            'media' => 1,
            'created_at' => time(),
            'updated_at' => time(),
        ];
        DB::table('files')->insertGetId($data);
        $data['url'] = iGenerateFileUrl($dir, $name);
        return $data;
    }


    public static function index(Request $request, $offset = 0, $limit = 100)
    {
        $userIds = User::getUidsInSameGroup($request->user);

        $hasPermission = User::hasPermission($request->user, generatePermissionName(__CLASS__, __FUNCTION__));
        if (!$hasPermission) {
            return response()->json(config('tips.user.id.noPermission'));
        }

        $folder = $request->input('folder', '/');
        $folder = Folder::formatFolder($folder);


        $count = DB::table('files')->whereIn('user_id', $userIds)->where('folder', '<>', $folder)->where('folder',
            'like', $folder . '%')->orderBy('folder', 'asc')->orderBy('name',
            'asc')->count();
        if (!$count) {
            return response()->json(config('tips.file.empty'));
        }

        $datas = DB::table('files')->whereIn('user_id', $userIds)->where('folder', '<>', $folder)->where('folder',
            'like', $folder . '%')->orderBy('folder', 'asc')->orderBy('name',
            'asc')->get();

        foreach ($datas as &$data) {
            $data->url = iGenerateFileUrl($request->user->group, $data->name);
        }

        return response()->json([
                'code' => 0,
                'msg' => 'The file from ' . $offset . ',len ' . $limit,
                'data' => $datas,
                'count' => $count,
            ]
        );
    }

    public static function store(Request $request)
    {
        $hasPermission = User::hasPermission($request->user, generatePermissionName(__CLASS__, __FUNCTION__));
        if (!$hasPermission) {
            return response()->json(config('tips.user.id.noPermission'));
        }

        //接受files
        $files = $request->file('file');
        if (!$files) {
            return response()->json(config('tips.file.empty'));
        }
        $data = [];
        if (is_array($files)) {
            foreach ($files as $file) {
                $data[] = self::storeFileBasic($file, $request);
            }
        } elseif (is_object($files)) {
            $file = $files;
            $data = self::storeFileBasic($file, $request);
        } else {
            //
        }
        return response()->json([
            'code' => 0,
            'msg' => 'The file store successfully',
            'data' => $data,
        ]);
    }

    public static function move(Request $request, $uuid)
    {
        $hasPermission = User::hasPermission($request->user, generatePermissionName(__CLASS__, __FUNCTION__));
        if (!$hasPermission) {
            return response()->json(config('tips.user.id.noPermission'));
        }

        $folder = $request->input('folder', '/');
        $folder = Folder::formatFolder($folder);

        $result = DB::table('files')->where('uuid', $uuid)->update(['folder' => $folder]);
        if (!$result) {
            return response()->json(config('tips.file.move.failure'));
        }

        return response()->json([
                'code' => 0,
                'msg' => 'The file decrement successfully',
            ]
        );
    }

    public static function del(Request $request, $uuid)
    {
        $model = DB::table('files')->where('uuid', $uuid)->first();
        $model->permissionName = generatePermissionName(__CLASS__, __FUNCTION__);
        $hasPermission = User::hasPermission($request->user, $model, 1);
        if (!$hasPermission) {
            return response()->json(config('tips.user.id.noPermission'));
        }

        $result = DB::table('files')->where('uuid', $uuid)->update(['media', 0]);
        if (!$result) {
            return response()->json(config('tips.file.delete.failure'));
        }

        return response()->json([
                'code' => 0,
                'msg' => 'The file decrement successfully',
            ]
        );
    }
}
