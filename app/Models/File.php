<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Intervention\Image\ImageManagerStatic as Image;

class File extends Model
{
    public static function index(Request $request)
    {
        $userId = $request->user->id;
        $folder = $request->input('folder', '/');
        $folder = Folder::formatFolder($folder);
        $offset = $request->input('start', 0);
        $limit = $request->input('len', 10);

        $files = DB::table('files')->where('user_id', $userId)->where('folder', 'like',
            $folder . '%')->whereNotNull('name')->orderBy('name',
            'asc')->offset($offset)->limit($limit);

        $datas = DB::table('files')->where('user_id', $userId)->where('folder', '<>', $folder)->where('folder',
            'like', $folder . '%')->whereNull('name')->orderBy('folder', 'asc')->orderBy('name',
            'asc')->union($files)->get();

        foreach ($datas as &$data) {
            $data->url = iGenerateFileUrl($data->uuid, $data->name);
        }
        $count = 1;//默认有数据
        if ($offset == 0) {
            $files = DB::table('files')->where('user_id', $userId)->where('folder', 'like',
                $folder . '%')->whereNotNull('name')->orderBy('name', 'asc')->count();

            $count = DB::table('files')->where('user_id', $userId)->where('folder', '<>', $folder)->where('folder',
                'like', $folder . '%')->whereNull('name')->orderBy('folder', 'asc')->orderBy('name',
                'asc')->count();
            $count += $files;
            //$count = DB::table('files')->where('user_id', $userId)->where('folder', 'like', $folder . '%')->count();
        }
        if (!$count) {
            return response()->json(config('tips.file.empty'));
        }
        return response()->json([
                'code' => 0,
                'msg' => 'The files from ' . $offset . ',len ' . $limit,
                'msg_zh' => '从 ' . $offset . ' 开始，长 ' . $limit . ' 的文件',
                'data' => $datas,
                'count' => $count,
            ]
        );
    }

    private static function storeFileBasic(UploadedFile $file, Request $request)
    {
        $userId = $request->user->id;
        $folder = $request->input('folder', '/');
        $folder = Folder::formatFolder($folder);
        $media = $request->input('media', 0);
        //校验文件：大小，宽高，格式等限制
        iCheckFile($file);
        //or
        //$image = Image::make($file);
        //$image->width(),$image->height(),$image->filesize(),$file->getClientOriginalExtension(),$image->mime();

        //上传到服务器（屋里地址固定）
        $dir = $userId;
        $name = date('YmdHis') . mt_rand(1000, 9999) . '.' . $file->getClientOriginalExtension();
        $size = $file->getSize();
        $file->storeAs('public/' . $dir . '/', $name);

        //物理地址:storage/app/public/为根
        //or
        //$in = storage_path('app/public/' . $uuid . '/' . $name);//需要事先生成文件夹
        //$image->save($in);

        //缩略图
        //$image->resize(300, 300)->save($in . '_300_300.jpg');
        //保存记录到数据库
        $uuid = iGenerateUuid();
        $data = [
            'uuid' => $uuid,
            'user_id' => $userId,
            'folder' => $folder,
            'name' => $name,
            'size' => $size,
            'media_num' => $media ? 1 : 0,
            'used_num' => $media ? 0 : 1,
            'created_at' => time(),
            'updated_at' => time(),
        ];
        DB::table('files')->insertGetId($data);
        //生成并返回绝对地址.'###'.$uuid
        $data['url'] = iGenerateFileUrl($uuid, $name);
        return $data;
    }

    public static function store(Request $request)
    {
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
            'msg_zh' => '文件添加成功',
            'data' => $data,
        ]);
    }

    public static function inc(Request $request, $uuid)
    {
        $userId = $request->user->id;
        $media = $request->input('media', 0);
        if ($media) {
            $result = DB::table('files')->where('user_id', $userId)->where('uuid', $uuid)->increment('media_num');
        } else {
            $result = DB::table('files')->where('user_id', $userId)->where('uuid', $uuid)->increment('used_num');
        }
        if (!$result) {
            return response()->json(config('tips.file.increment.failure'));
        }
        return response()->json([
                'code' => 0,
                'msg' => 'The file increment successfully',
                'msg_zh' => '文件使用成功',
            ]
        );
    }

    public static function dec(Request $request, $uuid)
    {
        $userId = $request->user->id;
        $media = $request->input('media', 0);
        if ($media) {
            $result = DB::table('files')->where('user_id', $userId)->where('uuid', $uuid)->decrement('media_num');
        } else {
            $result = DB::table('files')->where('user_id', $userId)->where('uuid', $uuid)->decrement('used_num');
        }
        if (!$result) {
            return response()->json(config('tips.file.decrement.failure'));
        }
        return response()->json([
                'code' => 0,
                'msg' => 'The file decrement successfully',
                'msg_zh' => '文件删除成功',
            ]
        );
    }

    public static function move(Request $request, $uuid)
    {
        $userId = $request->user->id;
        $folder = $request->input('folder', '/');
        $folder = Folder::formatFolder($folder);
        $result = DB::table('files')->where('user_id', $userId)->where('uuid',
            $uuid)->update(['folder' => $folder]);
        if (!$result) {
            return response()->json(config('tips.file.move.failure'));
        }
        return response()->json([
                'code' => 0,
                'msg' => 'The file decrement successfully',
                'msg_zh' => '文件移动成功',
            ]
        );
    }
}
