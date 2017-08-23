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
        'noPermission' => [
            'code' => 100003,
            'msg' => 'The current user has no permission',
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
            'format' => [
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
            'format' => [
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
    'articleCate' => [
        'name' => [
            'required' => [
                'code' => 100201,
                'msg' => 'The article cate name should not be empty',
            ]
        ],
        'empty' => [
            'code' => 100202,
            'msg' => 'The article cate is empty',
        ],
        'existing' => [
            'code' => 100203,
            'msg' => 'The article cate name is existing',
        ],
        'edit' => [
            'failure' => [
                'code' => 100204,
                'msg' => 'The article cate edit unsuccessfully',
            ]
        ],
        'delete' => [
            'failure' => [
                'code' => 100205,
                'msg' => 'The article cate delete unsuccessfully',
            ]
        ]
    ],
    'articleTag' => [
        'name' => [
            'required' => [
                'code' => 100206,
                'msg' => 'The article tag name should not be empty',
            ]
        ],
        'empty' => [
            'code' => 100207,
            'msg' => 'The article tag is empty',
        ],
        'existing' => [
            'code' => 100208,
            'msg' => 'The article tag name is existing',
        ],
        'edit' => [
            'failure' => [
                'code' => 100209,
                'msg' => 'The article tag edit unsuccessfully',
            ]
        ],
        'delete' => [
            'failure' => [
                'code' => 100210,
                'msg' => 'The article tag delete unsuccessfully',
            ]
        ]
    ],
    'article' => [
        'name' => [
            'required' => [
                'code' => 100211,
                'msg' => 'The name should not be empty',
            ],
        ],
        'empty' => [
            'code' => 100212,
            'msg' => 'The article is empty',
        ],
        'existing' => [
            'code' => 100213,
            'msg' => 'The article code is existing',
        ],
        'edit' => [
            'failure' => [
                'code' => 100214,
                'msg' => 'The article edit unsuccessfully',
            ]
        ],
        'delete' => [
            'failure' => [
                'code' => 100215,
                'msg' => 'The article delete unsuccessfully',
            ]
        ]
    ],
    'productAttr' => [
        'name' => [
            'required' => [
                'code' => 100301,
                'msg' => 'The product attrs name should not be empty',
            ]
        ],
        'empty' => [
            'code' => 100302,
            'msg' => 'The product attrs is empty',
        ],
        'existing' => [
            'code' => 100303,
            'msg' => 'The product attrs name is existing',
        ],
        'edit' => [
            'failure' => [
                'code' => 100304,
                'msg' => 'The product attrs edit unsuccessfully',
            ]
        ],
        'delete' => [
            'failure' => [
                'code' => 100305,
                'msg' => 'The product attrs delete unsuccessfully',
            ]
        ]
    ],
    'productParam' => [
        'name' => [
            'required' => [
                'code' => 100306,
                'msg' => 'The product param name should not be empty',
            ]
        ],
        'empty' => [
            'code' => 100307,
            'msg' => 'The product param is empty',
        ],
        'existing' => [
            'code' => 100308,
            'msg' => 'The product param name is existing',
        ],
        'edit' => [
            'failure' => [
                'code' => 100309,
                'msg' => 'The product param edit unsuccessfully',
            ]
        ],
        'delete' => [
            'failure' => [
                'code' => 100310,
                'msg' => 'The product param delete unsuccessfully',
            ]
        ]
    ],
    'product' => [
        'name' => [
            'required' => [
                'code' => 100311,
                'msg' => 'The name should not be empty',
            ],
        ],
        'empty' => [
            'code' => 100312,
            'msg' => 'The product is empty',
        ],
        'code'=>[
            'existing' => [
                'code' => 100313,
                'msg' => 'The product code is existing',
            ],
        ],
        'edit' => [
            'failure' => [
                'code' => 100314,
                'msg' => 'The product edit unsuccessfully',
            ]
        ],
        'delete' => [
            'failure' => [
                'code' => 100315,
                'msg' => 'The product delete unsuccessfully',
            ]
        ]
    ],
    'file' => [
        'empty' => [
            'code' => 100401,
            'msg' => 'The file is empty',
        ],
        'move' => [
            'failure' => [
                'code' => 100404,
                'msg' => 'The file move unsuccessfully',
            ]
        ],
    ],
    'folder' => [
        'empty' => [
            'code' => 100405,
            'msg' => 'The folder is empty',
        ],
        'format' => [
            'code' => 100406,
            'msg' => 'The folder name is not right',
        ],
        'existing' => [
            'code' => 100407,
            'msg' => 'The folder is existing',
        ],
        'edit' => [
            'failure' => [
                'code' => 100408,
                'msg' => 'The folder unsuccessfully',
            ]
        ],
        'delete' => [
            'existFiles' => [
                'code' => 100409,
                'msg' => 'There are files in this folder',
            ],
            'failure' => [
                'code' => 100410,
                'msg' => 'The folder delete unsuccessfully',
            ]
        ],
    ],
];