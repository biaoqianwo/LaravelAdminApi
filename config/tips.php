<?php

return [
    'token' => [
        'empty' => [
            'code' => 100001,
            'msg' => 'The token is empty',
            'msg_zh' => 'Token不存在',
        ],
        'invalid' => [
            'code' => 100002,
            'msg' => 'The token is invalid',
            'msg_zh' => 'Token无效',
        ],
    ],
    'user' => [
        'id' => [
            'noPermission' => [
                'code' => 100101,
                'msg' => 'The current user has no permission',
                'msg_zh' => '当前用户没有权限',
            ],
        ],
        'group' => [
            'notUnique' => [
                'code' => 100102,
                'msg' => 'The group is not unique',
                'msg_zh' => '组织不唯一，请输入组织',
            ],
        ],
        'email' => [
            'required' => [
                'code' => 100103,
                'msg' => 'The email should not be empty',
                'msg_zh' => '邮箱不能为空',
            ],
            'email' => [
                'code' => 100104,
                'msg' => 'The email is not right',
                'msg_zh' => '邮箱格式不正确',
            ],
            'notRegister' => [
                'code' => 100105,
                'msg' => 'The email does not register',
                'msg_zh' => '邮箱尚未注册',
            ],
            'registered' => [
                'code' => 100106,
                'msg' => 'The email has been registered',
                'msg_zh' => '邮箱已经注册',
            ]
        ],
        'name' => [
            'required' => [
                'code' => 100107,
                'msg' => 'The name should not be empty',
                'msg_zh' => '用户名不能为空',
            ],
            'alpha' => [
                'code' => 100108,
                'msg' => 'The name is not right',
                'msg_zh' => '用户名格式不正确，只能是字母',
            ],
            'max' => [
                'code' => 100109,
                'msg' => 'The name max length is 64',
                'msg_zh' => '用户名最长64',
            ],
            'notRegister' => [
                'code' => 100110,
                'msg' => 'The name does not register',
                'msg_zh' => '用户名尚未注册',
            ],
            'registered' => [
                'code' => 100111,
                'msg' => 'The name has been registered',
                'msg_zh' => '用户名已经注册',
            ]
        ],
        'password' => [
            'required' => [
                'code' => 100112,
                'msg' => 'The password should not be empty',
                'msg_zh' => '密码不能为空',
            ],
            'notRight' => [
                'code' => 10113,
                'msg' => 'The password is not right',
                'msg_zh' => '密码不正确',
            ],
        ],
        'emailOrName' => [
            'required' => [
                'code' => 10114,
                'msg' => 'The email or name should not be empty',
                'msg_zh' => '邮箱/用户名不能为空',
            ],
        ],
        'uuid' => [
            'empty' => [
                'code' => 100115,
                'msg' => 'The user is empty',
                'msg_zh' => '用户不存在',
            ],
        ],
        'edit' => [
            'failure' => [
                'code' => 100116,
                'msg' => 'The user edit unsuccessfully',
                'msg_zh' => '用户编辑失败，可能不存在或者没权限',
            ]
        ],
        'delete' => [
            'failure' => [
                'code' => 100117,
                'msg' => 'The user delete unsuccessfully',
                'msg_zh' => '用户删除失败，可能已被删除或者没权限',
            ]
        ]
    ],
    'product' => [
        'empty' => [
            'code' => 100201,
            'msg' => 'The product is empty',
            'msg_zh' => '产品不存在',
        ],
        'existing' => [
            'code' => 100202,
            'msg' => 'The product code is existing',
            'msg_zh' => '产品编号已经存在',
        ],
        'edit' => [
            'failure' => [
                'code' => 100203,
                'msg' => 'The product edit unsuccessfully',
                'msg_zh' => '产品编辑失败，可能不存在或者没权限',
            ]
        ],
        'delete' => [
            'failure' => [
                'code' => 100204,
                'msg' => 'The product delete unsuccessfully',
                'msg_zh' => '产品删除失败，可能已被删除或者没权限',
            ]
        ]
    ],
    'productAttrs' => [
        'name' => [
            'required' => [
                'code' => 100300,
                'msg' => 'The product attrs name should not be empty',
                'msg_zh' => '产品属性的名称不能为空',
            ]
        ],
        'empty' => [
            'code' => 100301,
            'msg' => 'The product attrs is empty',
            'msg_zh' => '产品属性不存在',
        ],
        'existing' => [
            'code' => 100302,
            'msg' => 'The product attrs name is existing',
            'msg_zh' => '产品属性名称已经存在',
        ],
        'edit' => [
            'failure' => [
                'code' => 100303,
                'msg' => 'The product attrs edit unsuccessfully',
                'msg_zh' => '产品属性编辑失败，可能不存在或者没权限',
            ]
        ],
        'delete' => [
            'failure' => [
                'code' => 100304,
                'msg' => 'The product attrs delete unsuccessfully',
                'msg_zh' => '产品属性删除失败，可能已被删除或者没权限',
            ]
        ]
    ],
    'productTags' => [
        'name' => [
            'required' => [
                'code' => 100400,
                'msg' => 'The product tags name should not be empty',
                'msg_zh' => '产品标签的名称不能为空',
            ]
        ],
        'empty' => [
            'code' => 100401,
            'msg' => 'The product tags is empty',
            'msg_zh' => '产品标签不存在',
        ],
        'existing' => [
            'code' => 100402,
            'msg' => 'The product tags name is existing',
            'msg_zh' => '产品标签名称已经存在',
        ],
        'edit' => [
            'failure' => [
                'code' => 100403,
                'msg' => 'The product tags edit unsuccessfully',
                'msg_zh' => '产品标签编辑失败，可能不存在或者没权限',
            ]
        ],
        'delete' => [
            'failure' => [
                'code' => 100404,
                'msg' => 'The product tags delete unsuccessfully',
                'msg_zh' => '产品标签删除失败，可能已被删除或者没权限',
            ]
        ]
    ],
    'file' => [
        'empty' => [
            'code' => 100501,
            'msg' => 'The file is empty',
            'msg_zh' => '文件不存在',
        ],
        'increment' => [
            'failure' => [
                'code' => 100502,
                'msg' => 'The file increment unsuccessfully',
                'msg_zh' => '文件使用失败，可能已被删除或者没权限',
            ]
        ],
        'decrement' => [
            'failure' => [
                'code' => 100503,
                'msg' => 'The file decrement unsuccessfully',
                'msg_zh' => '文件删除失败，可能已被删除或者没权限',
            ]
        ],
        'move' => [
            'failure' => [
                'code' => 100504,
                'msg' => 'The file move unsuccessfully',
                'msg_zh' => '文件移动失败，可能已被删除或者没权限',
            ]
        ],
    ],
    'folder' => [
        'empty' => [
            'code' => 100505,
            'msg' => 'The folder is empty',
            'msg_zh' => '文件不存在',
        ],
        'format' => [
            'code' => 100506,
            'msg' => 'The folder name is not right',
            'msg_zh' => '文件夹名称格式不正确，只能是字母数字斜线',
        ],
        'existing' => [
            'code' => 100507,
            'msg' => 'The folder is existing',
            'msg_zh' => '文件夹已经存在',
        ],
        'edit' => [
            'failure' => [
                'code' => 100508,
                'msg' => 'The folder unsuccessfully',
                'msg_zh' => '文件夹编辑失败，可能不存在或者没权限',
            ]
        ],
        'delete' => [
            'existFiles' => [
                'code' => 100509,
                'msg' => 'The folder has files',
                'msg_zh' => '文件夹删除失败，存在文件',
            ],
            'failure' => [
                'code' => 100510,
                'msg' => 'The folder delete unsuccessfully',
                'msg_zh' => '文件夹删除失败，可能已被删除或者没权限',
            ]
        ],
    ],
];