<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

//use Illuminate\Support\Facades\Redis;

class User extends Model
{
    /**
     * 生成注册之后返回的用户对象
     * @param $user
     * @return \stdClass
     */
    private static function generateUser($user)
    {
        unset($user->pwd);
        $rs = new \stdClass();
        $rs->user = $user;
        $rs->token = iEncodeToken($user->uuid);;
        return $rs;
    }

    /**
     * 根据token获取用户
     * @param $token
     * @return Model|null|static
     */
    public static function getUserByToken($token)
    {
        $uuid = iDecodeToken($token)['uuid'];

        $result = self::where('uuid', $uuid)->first();

        if ($result) {
            unset($result->pwd);
        }
        return $result;
    }

    /**
     * 相同组下的管理员IDs
     * @param $user
     * @return array
     */
    public static function getUidsInSameGroup($user)
    {
        if ($user->user_num > 1) {
            return DB::table('users')->where('group', $user->group)->pluck('id')->toArray();
        }
        return [$user->id];
    }


    /**
     * 判断用户是否有权限
     * @param $user is_super=1超级管理员拥有全部权限，不受$inPermissions影响
     * @param $model
     * @param int $inPermissions 1强权限表示自己添加，且被赋予操作权限，0弱权限：自己添加即有权限
     * @return bool
     */
    public static function hasPermission($user, $model, $inPermissions = 0)
    {
        if (is_string($model)) {//$model = XXX.index,XXX.store,...
            if ($user->is_super) {
                return true;
            }

            if (empty($user->permissionName)) {
                return false;
            }

            $permissions = json_decode($user->permissions, true);
            if (in_array($model, $permissions)) {
                return true;
            }
            return false;
        }

        //$model=Obj{user_id=1,permissionName='XXX.edit',...}
        if (!is_object($model) || empty($model->permissionName)) {
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
            if (!empty($model->group) && $user->group == $model->group) {
                return true;
            }
            $group = self::where('user_id', $model->user_id)->value('group');
            if ($user->group == $group) {
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

    /**
     * 验证邮箱是否注册
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public static function existEmail(Request $request)
    {
        $email = $request->input('email', null);
        if (!$email) {
            return response()->json(config('tips.user.email.required'));
        }
        if (!iValidateString($email, 'email')) {
            return response()->json(config('tips.user.email.format'));
        }

        $result = DB::table('users')->where('email', $email)->value('group');
        if (!$result) {
            return response()->json(config('tips.user.email.notRegister'));
        }
        return response()->json(array_merge(['data' => $result], config('tips.user.email.registered')));
    }

    /**
     * 验证用户名是否注册
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public static function existName(Request $request)
    {
        $name = $request->input('name', null);
        if (!$name) {
            return response()->json(config('tips.user.name.required'));
        }
        if (!iValidateString($name, 'alpha')) {
            return response()->json(config('tips.user.name.format'));
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
        $name = $request->input('name', null);
        $email = $request->input('email', null);
        $pwd = $request->input('password', null);

        $result = User::existName($request);
        $tmp = json_decode($result->getContent());
        if ($tmp->code != config('tips.user.name.notRegister.code')) {
            return $result;
        }

        $result = User::existEmail($request);
        $tmp = json_decode($result->getContent());
        if ($tmp->code != config('tips.user.email.notRegister.code')) {
            return $result;
        }

        if (!$pwd) {
            return response()->json(config('tips.user.password.required'));
        }

        $data = [
            'uuid' => iGenerateUuid(),
            'group' => $name,
            'name' => $name,
            'email' => $email,
            'pwd' => iMd5($pwd),
            'is_super' => 1,
            'created_at' => time(),
            'updated_at' => time()
        ];
        DB::table('users')->insertGetId($data);

        //todo 发送邮件队列...
        return response()->json(
            [
                'code' => 0,
                'msg' => 'The user register successfully',
            ]
        );
    }

    public static function login(Request $request)
    {
        $group = $request->input('group', null);
        $emailOrName = $request->input('name', null);
        $pwd = $request->input('password', null);
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
                    'data' => self::generateUser($result),
                ]
            );
        }
    }


    ////////////////////////////////////////////////////////////////

    public static function index(Request $request, $offset = 0, $limit = 1000)
    {
        $hasPermission = User::hasPermission($request->user, generatePermissionName(__CLASS__, __FUNCTION__));
        if (!$hasPermission) {
            return response()->json(config('tips.user.id.noPermission'));
        }

        $user = $request->user;

        $count = DB::table('users')->where('group', $user->group)->count();

        $datas = DB::table('users')->where('group', $user->group)->offset($offset)->limit($limit)->get();

        return response()->json([
                'code' => 0,
                'msg' => 'The user from ' . $offset . ',len ' . $limit,
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

        $name = $request->input('name', null);
        if (!$name) {
            return response()->json(config('tips.user.name.required'));
        }
        if (!iValidateString($name, 'alpha')) {
            return response()->json(config('tips.user.name.format'));
        }
        if (!iValidateString($name, 'max:64')) {
            return response()->json(config('tips.user.name.max'));
        }
        $count = DB::table('users')->where('group', $request->user->group)->where('name', $name)->count();
        if ($count) {
            return response()->json(config('tips.user.name.registered'));
        }

        $email = $request->input('email', null);
        if (!$email) {
            return response()->json(config('tips.user.email.required'));
        }
        if (!iValidateString($email, 'email')) {
            return response()->json(config('tips.user.email.format'));
        }
        $count = DB::table('users')->where('group', $request->user->group)->where('email', $email)->count();
        if ($count) {
            return response()->json(config('tips.user.email.registered'));
        }

        $data = [
            'uuid' => iGenerateUuid(),
            'user_id' => $request->user->id,
            'group' => $request->user->group,
            'name' => $name,
            'email' => $email,
            'pwd' => iMd5('1234'),
            'created_at' => time(),
            'updated_at' => time(),
        ];
        DB::table('users')->insertGetId($data);

        return response()->json([
            'code' => 0,
            'msg' => 'The user store successfully',
            'data' => $data,
        ]);
    }

    public static function show(Request $request, $uuid)
    {
        $data = DB::table('users')->where('group', $request->user->group)->where('uuid', $uuid)->first();
        if (!$data) {
            return response()->json(config('tips.user.empty'));
        }

        $data->permissionName = generatePermissionName(__CLASS__, __FUNCTION__);
        $hasPermission = User::hasPermission($request->user, $data);
        if (!$hasPermission) {
            return response()->json(config('tips.user.id.noPermission'));
        }
        unset($data->permissionName);

        return response()->json([
                'code' => 0,
                'msg' => 'The users show successfully',
                'data' => $data,
            ]
        );
    }

    public static function edit(Request $request, $uuid)
    {
        $name = $request->input('name', null);
        if ($name) {
            if (!iValidateString($name, 'alpha')) {
                return response()->json(config('tips.user.name.format'));
            }
            if (!iValidateString($name, 'max:64')) {
                return response()->json(config('tips.user.name.max'));
            }
            $count = DB::table('users')->where('group', $request->user->group)->where('name', $name)->count();
            if ($count) {
                return response()->json(config('tips.user.name.registered'));
            }
        }

        $email = $request->input('email', null);
        if ($email) {
            if (!iValidateString($email, 'email')) {
                return response()->json(config('tips.user.email.format'));
            }

            $count = DB::table('users')->where('group', $request->user->group)->where('email', $email)->count();
            if ($count) {
                return response()->json(config('tips.user.email.registered'));
            }
        }

        $data = ['updated_at' => time(),];
        if ($name) {
            $data['name'] = $name;
        }
        if ($email) {
            $data['email'] = $email;
        }

        $model = DB::table('users')->where('uuid', $uuid)->first();
        if (!$model) {
            return response()->json(config('tips.user.empty'));
        }

        $model->permissionName = generatePermissionName(__CLASS__, __FUNCTION__);
        $hasPermission = User::hasPermission($request->user, $model);
        if (!$hasPermission) {
            return response()->json(config('tips.user.id.noPermission'));
        }

        $result = DB::table('users')->where('uuid', $uuid)->update($data);
        if (!$result) {
            return response()->json(config('tips.user.edit.failure'));
        }

        return response()->json([
            'code' => 0,
            'msg' => 'The 用户 edit successfully',
            'data' => $data,
        ]);
    }

    public static function del(Request $request, $uuid)
    {
        $model = DB::table('users')->where('uuid', $uuid)->first();
        if (!$model) {
            return response()->json(config('tips.user.empty'));
        }

        $model->permissionName = generatePermissionName(__CLASS__, __FUNCTION__);
        $hasPermission = User::hasPermission($request->user, $model, 1);
        if (!$hasPermission) {
            return response()->json(config('tips.user.id.noPermission'));
        }

        if ($model->is_super) {
            return response()->json(config('tips.user.id.noPermission'));
        }

        $result = DB::table('users')->where('uuid', $uuid)->delete();
        if (!$result) {
            return response()->json(config('tips.user.delete.failure'));
        }

        return response()->json([
                'code' => 0,
                'msg' => 'The user delete successfully',
            ]
        );
    }
}
