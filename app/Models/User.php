<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

//use Illuminate\Support\Facades\Redis;

class User extends Model
{
    public static function existEmail(Request $request)
    {
        $email = $request->input('email');
        if (!$email) {
            return response()->json(config('tips.user.email.required'));
        }
        if (!iValidateString($email, 'email')) {
            return response()->json(config('tips.user.email.email'));
        }

        $result = DB::table('users')->where('email', $email)->value('group');

        if (!$result) {
            return response()->json(config('tips.user.email.notRegister'));
        }
        return response()->json(array_merge(['data' => $result], config('tips.user.email.registered')));
    }

    public static function existName(Request $request)
    {
        $name = $request->input('name');
        if (!$name) {
            return response()->json(config('tips.user.name.required'));
        }
        if (!iValidateString($name, 'alpha')) {
            return response()->json(config('tips.user.name.alpha'));
        }
        if (!iValidateString($name, 'max:64')) {
            return response()->json(config('tips.user.name.max'));
        }

        $result = DB::table('users')->where('name', $name)->value('group');
        if (!$result) {
            return response()->json(config('tips.user.name.notRegister'));
        }
        return response()->json(array_merge(['data' => $result], config('tips.user.name.registered')));
    }

    public static function register(Request $request)
    {
        $email = $request->input('email');
        $name = $request->input('name');
        $pwd = $request->input('password');

        $result = User::existEmail($request);
        $tmp = json_decode($result->getContent());
        if ($tmp->code != config('tips.user.email.notRegister.code')) {
            return $result;
        }

        $result = User::existName($request);
        $tmp = json_decode($result->getContent());
        if ($tmp->code != config('tips.user.name.notRegister.code')) {
            return $result;
        }

        if (!$pwd) {
            return response()->json(config('tips.user.password.required'));
        }

        $id = DB::table('users')->insertGetId(
            [
                'uuid' => iGenerateUuid(),
                'group' => $name,
                'name' => $name,
                'email' => $email,
                'pwd' => iMd5($pwd),
                'is_super' => 1,
                'created_at' => time(),
                'updated_at' => time()
            ]
        );


        //todo 发送邮件队列...
        return response()->json(
            [
                'code' => 0,
                'msg' => 'The user register successfully',
                'msg_zh' => '用户注册成功',
                'data' => $id,
            ]
        );
    }

    public static function login(Request $request)
    {
        $group = $request->input('group');
        $emailOrName = $request->input('name');
        $pwd = $request->input('password');
        if (!$emailOrName) {
            return response()->json(config('tips.user.emailOrName.required'));
        }
        if (!$pwd) {
            return response()->json(config('tips.user.password.required'));
        }


        if (iValidateString($emailOrName, 'email')) {
            if ($group) {
                $result = DB::table('users')->where('group', $group)->where('email', $emailOrName)->first();
            } else {
                $result = DB::table('users')->where('email', $emailOrName)->get();
                if (count($result) != 1) {
                    return response()->json(config('tips.user.group.notUnique'));
                }
                $result = $result[0];
            }
            if (!$result) {
                return response()->json(config('tips.user.email.notRegister'));
            }
            if ($result->pwd != iMd5($pwd)) {
                return response()->json(config('tips.user.password.notRight'));
            }
            return response()->json([
                    'code' => 0,
                    'msg' => 'The user login successfully',
                    'msg_zh' => '用户登录成功',
                    'data' => self::generateUser($result),
                ]
            );
        } else {
            if ($group) {
                $result = DB::table('users')->where('group', $group)->where('name', $emailOrName)->first();
            } else {
                $result = DB::table('users')->where('name', $emailOrName)->get();

                if (count($result) != 1) {
                    return response()->json(config('tips.user.group.notUnique'));
                }
                $result = $result[0];
            }
            if (!$result) {
                return response()->json(config('tips.user.name.notRegister'));
            }
            if ($result->pwd != iMd5($pwd)) {
                return response()->json(config('tips.user.password.notRight'));
            }
            return response()->json([
                    'code' => 0,
                    'msg' => 'The user login successfully',
                    'msg_zh' => '用户登录成功',
                    'data' => self::generateUser($result),
                ]
            );
        }
    }

    private static function generateUser($user)
    {
        unset($user->pwd);
        $rs = new \stdClass();
        $rs->user = $user;
        $rs->token = iEncodeToken($user->uuid);;
        return $rs;
    }

    public static function getUser($token)
    {
        $uuid = iDecodeToken($token)['uuid'];
        return DB::table('users')->where('uuid', $uuid)->first();
    }

    /**
     * 根据管理员相同组下的管理员IDs
     * @param $group
     * @return array
     */
    public static function getUidsByGroup($group)
    {
        return DB::table('users')->where('group', $group)->pluck('id')->toArray();
    }


    /**
     * 判断用户是否有权限
     * @param $user
     * @param $model
     * @param int $inPermissions
     * @return bool
     */
    public static function hasPermission($user, $model, $inPermissions = 0)
    {
        if (!$model || empty($model->user_id) || empty($model->permissionName)) {
            return false;
        }


        if ($user->id == $model->user_id) {//自己添加
//            if ($inPermissions) {//强权限（且须有权限）
//                $permissions = json_decode($user->permissions, true);
//                if (in_array($model->permissionName, $permissions)) {
//                    return true;
//                }
//                return false;
//            }
            return true;
        } elseif ($user->is_super) {
            //超级管理员有权限
            $tmp = self::find($model->user_id);
            if ($user->group == $tmp->group) {
                return true;
            }
        } else {
            //不是超级管理员，不是自己：被赋予权限的有权限
            //$tmp = self::find($model->user_id);
            //$permissions = json_decode($user->permissions, true);
            //if ($user->group == $tmp->group && in_array($model->permissionName, $permissions)) {
            //    return true;
            //}
        }
        return false;
    }

    ////////////////////////////////////////////////////////////////

    public static function index(Request $request)
    {
        $user = $request->user;
        if (!$user->is_super) {
            return response()->json(config('tips.user.id.noPermission'));
        }
        $datas = DB::table('users')->where('group', $user->group)->get();
        $count = DB::table('users')->where('group', $user->group)->count();
        return response()->json([
                'code' => 0,
                'msg' => 'All users',
                'msg_zh' => '全部用户',
                'data' => $datas,
                'count' => $count,
            ]
        );
    }

    public static function store(Request $request)
    {
        $user = $request->user;
        if (!$user->is_super) {
            return response()->json(config('tips.user.id.noPermission'));
        }

        $email = $request->input('email');
        if (!$email) {
            return response()->json(config('tips.user.email.required'));
        }
        if (!iValidateString($email, 'email')) {
            return response()->json(config('tips.user.email.email'));
        }

        $name = $request->input('name');
        if (!$name) {
            return response()->json(config('tips.user.name.required'));
        }
        if (!iValidateString($name, 'alpha')) {
            return response()->json(config('tips.user.name.alpha'));
        }
        if (!iValidateString($name, 'max:64')) {
            return response()->json(config('tips.user.name.max'));
        }

        $count = DB::table('users')->where('group', $user->group)->where('email', $email)->count();
        if ($count) {
            return response()->json(config('tips.user.email.registered'));
        }

        $count = DB::table('users')->where('group', $user->group)->where('name', $name)->count();
        if ($count) {
            return response()->json(config('tips.user.name.registered'));
        }

        $data = [
            'uuid' => iGenerateUuid(),
            'group' => $user->group,
            'email' => $email,
            'name' => $name,
            'pwd' => iMd5('1234'),
            'created_at' => time(),
            'updated_at' => time(),
        ];
        $id = DB::table('users')->insertGetId($data);
        $data['id'] = $id;
        return response()->json([
            'code' => 0,
            'msg' => 'The user store successfully',
            'msg_zh' => '用户添加成功',
            'data' => $data,
        ]);
    }

    public static function show(Request $request, $uuid)
    {
        $user = $request->user;
        if (!$user->is_super) {
            return response()->json(config('tips.user.id.noPermission'));
        }

        $data = DB::table('users')->where('group', $user->group)->where('uuid', $uuid)->first();
        if (!$data) {
            return response()->json(config('tips.user.uuid.empty'));
        }

        return response()->json([
                'code' => 0,
                'msg' => 'The users show successfully',
                'msg_zh' => '用户查询成功',
                'data' => $data,
            ]
        );
    }

    public static function edit(Request $request, $uuid)
    {
        $user = $request->user;
        if (!$user->is_super) {
            return response()->json(config('tips.user.id.noPermission'));
        }

        $email = $request->input('email');
        if ($email && !iValidateString($email, 'email')) {
            return response()->json(config('tips.user.email.email'));
        }

        $name = $request->input('name');
        if ($name && !iValidateString($name, 'alpha')) {
            return response()->json(config('tips.user.name.alpha'));
        }
        if ($name && !iValidateString($name, 'max:64')) {
            return response()->json(config('tips.user.name.max'));
        }

        $count = DB::table('users')->where('group', $user->group)->where('email', $email)->count();
        if ($count) {
            return response()->json(config('tips.user.email.registered'));
        }

        $count = DB::table('users')->where('group', $user->group)->where('name', $name)->count();
        if ($count) {
            return response()->json(config('tips.user.name.registered'));
        }

        $data = [
            'email' => $email,
            'name' => $name,
            'updated_at' => time(),
        ];
        $result = DB::table('users')->where('group', $user->group)->where('uuid', $uuid)->update($data);
        if (!$result) {
            return response()->json(config('tips.user.edit.failure'));
        }
        return response()->json([
            'code' => 0,
            'msg' => 'The 用户 edit successfully',
            'msg_zh' => '用户编辑成功',
            'data' => $data,
        ]);
    }

    public static function del(Request $request, $uuid)
    {
        $user = $request->user;
        if (!$user->is_super) {
            return response()->json(config('tips.user.id.noPermission'));
        }

        $result = DB::table('users')->where('group', $user->group)->where('uuid', $uuid)->delete();
        if (!$result) {
            return response()->json(config('tips.user.delete.failure'));
        }
        return response()->json([
                'code' => 0,
                'msg' => 'The user delete successfully',
                'msg_zh' => '用户删除成功',
            ]
        );
    }
}
