<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    //return view('articles.index');
    return '正在紧张开发中......可联系QQ:704872038';
});

//注册用户为超级管理员：邮箱或者用户名唯一
Route::post('exist/email', 'RegisterController@existEmail');
Route::post('exist/name', 'RegisterController@existName');
Route::post('register', 'RegisterController@register');
Route::post('login', 'LoginController@login');

Route::namespace('V2')->prefix('v2')->group(function () {
    Route::get('articles/{pos}/{count?}', 'ArticlesController@index');
    Route::get('articles/{uuid}', 'ArticlesController@show');
});

Route::namespace('V1')->prefix('v1')->group(function () {
    //users
    Route::get('users/{pos}/{count?}', 'UsersController@index');
    Route::post('users', 'UsersController@store');
    Route::get('users/{uuid}', 'UsersController@show');
    Route::post('users/{uuid}', 'UsersController@edit');
    Route::delete('users/{uuid}', 'UsersController@destroy');

    //configs
    Route::get('configs/{pos}/{count?}', 'ConfigsController@index');
    Route::post('configs', 'ConfigsController@store');
    Route::get('configs/{uuid}', 'ConfigsController@show');
    Route::post('configs/{uuid}', 'ConfigsController@edit');
    Route::delete('configs/{uuid}', 'ConfigsController@destroy');

    //articleCates
    Route::get('articleCates/{pos}/{count?}', 'ArticleCatesController@index');
    Route::post('articleCates', 'ArticleCatesController@store');
    Route::get('articleCates/{uuid}', 'ArticleCatesController@show');
    Route::post('articleCates/{uuid}', 'ArticleCatesController@edit');
    Route::delete('articleCates/{uuid}', 'ArticleCatesController@destroy');

    //articleTags
    Route::get('articleTags/{pos}/{count?}', 'ArticleTagsController@index');
    Route::post('articleTags', 'ArticleTagsController@store');
    Route::get('articleTags/{uuid}', 'ArticleTagsController@show');
    Route::post('articleTags/{uuid}', 'ArticleTagsController@edit');
    Route::delete('articleTags/{uuid}', 'ArticleTagsController@destroy');

    //article
    Route::get('articles/{pos}/{count?}', 'ArticlesController@index');
    Route::post('articles', 'ArticlesController@store');
    Route::get('articles/{uuid}', 'ArticlesController@show');
    Route::post('articles/{uuid}', 'ArticlesController@edit');
    Route::delete('articles/{uuid}', 'ArticlesController@destroy');

    //productAttrs
    Route::get('productAttrs/{pos}/{count?}', 'ProductAttrsController@index');
    Route::post('productAttrs', 'ProductAttrsController@store');
    Route::get('productAttrs/{uuid}', 'ProductAttrsController@show');
    Route::post('productAttrs/{uuid}', 'ProductAttrsController@edit');
    Route::delete('productAttrs/{uuid}', 'ProductAttrsController@destroy');

    //productParams
    Route::get('productParams/{pos}/{count?}', 'ProductParamsController@index');
    Route::post('productParams', 'ProductParamsController@store');
    Route::get('productParams/{uuid}', 'ProductParamsController@show');
    Route::post('productParams/{uuid}', 'ProductParamsController@edit');
    Route::delete('productParams/{uuid}', 'ProductParamsController@destroy');

    //products
    Route::get('products/{pos}/{count?}', 'ProductsController@index');
    Route::post('products', 'ProductsController@store');
    Route::get('products/{uuid}', 'ProductsController@show');
    Route::post('products/{uuid}', 'ProductsController@edit');//上架下架也用此接口
    Route::delete('products/{uuid}', 'ProductsController@destroy');

    //files
    Route::get('files/{pos}/{count?}', 'FilesController@index');//查看文件
    Route::post('files/store', 'FilesController@store');//上传文件 file:file|file[]
    Route::post('files/{uuid}/move', 'FilesController@move');//移动
    Route::post('files/{uuid}/rename', 'FilesController@rename');//重命名
    Route::delete('files/{uuid}', 'FilesController@del');//删除
    //folders
    Route::post('folders', 'FoldersController@store');//添加文件夹
    Route::post('folders/{uuid}', 'FoldersController@edit');//编辑文件夹（修改名称）
    Route::post('folders/{uuid}/del', 'FoldersController@destroy');//删除（内部存在文件时不能删除）
});