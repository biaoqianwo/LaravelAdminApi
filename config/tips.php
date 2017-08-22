<?php

return [
    'token' => [
        'empty' => [
            'code' => 100001,
            'msg' => 'The token is empty',
        ],
        'invalid' => [
            'code' => 100002,
            'msg' => 'The token is invalid',
        ],
    ],
    'user' => [
        'id' => [
            'noPermission' => [
                'code' => 100101,
                'msg' => 'The current user has no permission',
            ],
        ],
        'group' => [
            'notUnique' => [
                'code' => 100102,
                'msg' => 'The group is not unique, please input "group"',
            ],
        ],
        'email' => [
            'required' => [
                'code' => 100103,
                'msg' => 'The email should not be empty',
            ],
            'email' => [
                'code' => 100104,
                'msg' => 'The email is not right',
            ],
            'notRegister' => [
                'code' => 100105,
                'msg' => 'The email does not register',
            ],
            'registered' => [
                'code' => 100106,
                'msg' => 'The email has been registered',
            ]
        ],
        'name' => [
            'required' => [
                'code' => 100107,
                'msg' => 'The name should not be empty',
            ],
            'alpha' => [
                'code' => 100108,
                'msg' => 'The name is not right, only [a-zA-Z]',
            ],
            'max' => [
                'code' => 100109,
                'msg' => 'The name length max is 64',
            ],
            'notRegister' => [
                'code' => 100110,
                'msg' => 'The name does not register',
            ],
            'registered' => [
                'code' => 100111,
                'msg' => 'The name has been registered',
            ]
        ],
        'password' => [
            'required' => [
                'code' => 100112,
                'msg' => 'The password should not be empty',
            ],
            'notRight' => [
                'code' => 10113,
                'msg' => 'The password is not right',
            ],
        ],
        'emailOrName' => [
            'required' => [
                'code' => 10114,
                'msg' => 'The email or name should not be empty',
            ],
        ],
        'uuid' => [
            'empty' => [
                'code' => 100115,
                'msg' => 'The user is not existing',
            ],
        ],
        'edit' => [
            'failure' => [
                'code' => 100116,
                'msg' => 'The user edit unsuccessfully',
            ]
        ],
        'delete' => [
            'failure' => [
                'code' => 100117,
                'msg' => 'The user delete unsuccessfully',
            ]
        ]
    ],
    'product' => [
        'empty' => [
            'code' => 100201,
            'msg' => 'The product is empty',
        ],
        'existing' => [
            'code' => 100202,
            'msg' => 'The product code is existing',
        ],
        'edit' => [
            'failure' => [
                'code' => 100203,
                'msg' => 'The product edit unsuccessfully',
            ]
        ],
        'delete' => [
            'failure' => [
                'code' => 100204,
                'msg' => 'The product delete unsuccessfully',
            ]
        ]
    ],
    'productAttr' => [
        'name' => [
            'required' => [
                'code' => 100300,
                'msg' => 'The product attrs name should not be empty',
            ]
        ],
        'empty' => [
            'code' => 100301,
            'msg' => 'The product attrs is empty',
        ],
        'existing' => [
            'code' => 100302,
            'msg' => 'The product attrs name is existing',
        ],
        'edit' => [
            'failure' => [
                'code' => 100303,
                'msg' => 'The product attrs edit unsuccessfully',
            ]
        ],
        'delete' => [
            'failure' => [
                'code' => 100304,
                'msg' => 'The product attrs delete unsuccessfully',
            ]
        ]
    ],
    'productTag' => [
        'name' => [
            'required' => [
                'code' => 100400,
                'msg' => 'The product tag name should not be empty',
            ]
        ],
        'empty' => [
            'code' => 100401,
            'msg' => 'The product tag is empty',
        ],
        'existing' => [
            'code' => 100402,
            'msg' => 'The product tag name is existing',
        ],
        'edit' => [
            'failure' => [
                'code' => 100403,
                'msg' => 'The product tag edit unsuccessfully',
            ]
        ],
        'delete' => [
            'failure' => [
                'code' => 100404,
                'msg' => 'The product tag delete unsuccessfully',
            ]
        ]
    ],
    'file' => [
        'empty' => [
            'code' => 100501,
            'msg' => 'The file is empty',
        ],
        'increment' => [
            'failure' => [
                'code' => 100502,
                'msg' => 'The file increment unsuccessfully',
            ]
        ],
        'decrement' => [
            'failure' => [
                'code' => 100503,
                'msg' => 'The file decrement unsuccessfully',
            ]
        ],
        'move' => [
            'failure' => [
                'code' => 100504,
                'msg' => 'The file move unsuccessfully',
            ]
        ],
    ],
    'folder' => [
        'empty' => [
            'code' => 100505,
            'msg' => 'The folder is empty',
        ],
        'format' => [
            'code' => 100506,
            'msg' => 'The folder name is not right',
        ],
        'existing' => [
            'code' => 100507,
            'msg' => 'The folder is existing',
        ],
        'edit' => [
            'failure' => [
                'code' => 100508,
                'msg' => 'The folder unsuccessfully',
            ]
        ],
        'delete' => [
            'existFiles' => [
                'code' => 100509,
                'msg' => 'There are files in this folder',
            ],
            'failure' => [
                'code' => 100510,
                'msg' => 'The folder delete unsuccessfully',
            ]
        ],
    ],
    'articleCate' => [
        'name' => [
            'required' => [
                'code' => 100600,
                'msg' => 'The article cate name should not be empty',
            ]
        ],
        'empty' => [
            'code' => 100601,
            'msg' => 'The article cate is empty',
        ],
        'existing' => [
            'code' => 100602,
            'msg' => 'The article cate name is existing',
        ],
        'edit' => [
            'failure' => [
                'code' => 100603,
                'msg' => 'The article cate edit unsuccessfully',
            ]
        ],
        'delete' => [
            'failure' => [
                'code' => 100604,
                'msg' => 'The article cate delete unsuccessfully',
            ]
        ]
    ],
    'articleTag' => [
        'name' => [
            'required' => [
                'code' => 100600,
                'msg' => 'The article tag name should not be empty',
            ]
        ],
        'empty' => [
            'code' => 100601,
            'msg' => 'The article tag is empty',
        ],
        'existing' => [
            'code' => 100602,
            'msg' => 'The article tag name is existing',
        ],
        'edit' => [
            'failure' => [
                'code' => 100603,
                'msg' => 'The article tag edit unsuccessfully',
            ]
        ],
        'delete' => [
            'failure' => [
                'code' => 100604,
                'msg' => 'The article tag delete unsuccessfully',
            ]
        ]
    ],
];