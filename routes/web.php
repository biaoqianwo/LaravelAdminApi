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
    return 'hello world';
});


//注册用户为超级管理员：邮箱或者用户名唯一
Route::post('existEmail', 'RegisterController@existEmail');
Route::post('existName', 'RegisterController@existName');
Route::post('register', 'RegisterController@register');
Route::post('login', 'LoginController@login');

Route::namespace('V1')->prefix('v1')->group(function () {
    //users
    Route::get('users', 'UsersController@index');
    Route::post('users', 'UsersController@store');
    Route::get('users/{uuid}', 'UsersController@show');
    Route::post('users/{uuid}', 'UsersController@edit');
    Route::delete('users/{uuid}', 'UsersController@destroy');

    //products
    Route::get('products', 'ProductsController@index');
    Route::post('products', 'ProductsController@store');
    Route::get('products/{uuid}', 'ProductsController@show');
    Route::post('products/{uuid}', 'ProductsController@edit');//上架下架也用此接口
    Route::delete('products/{uuid}', 'ProductsController@destroy');

    //productAttrs
    Route::get('productAttrs', 'ProductAttrsController@index');
    Route::post('productAttrs', 'ProductAttrsController@store');
    Route::get('productAttrs/{uuid}', 'ProductAttrsController@show');
    Route::post('productAttrs/{uuid}', 'ProductAttrsController@edit');
    Route::delete('productAttrs/{uuid}', 'ProductAttrsController@destroy');

    //productTags
    Route::get('productTags', 'ProductTagsController@index');
    Route::post('productTags', 'ProductTagsController@store');
    Route::get('productTags/{uuid}', 'ProductTagsController@show');
    Route::post('productTags/{uuid}', 'ProductTagsController@edit');
    Route::delete('productTags/{uuid}', 'ProductTagsController@destroy');

    //files
    Route::get('files',  'FilesController@index');
    Route::post('files', 'FilesController@store');//上传文件 file:file|file[],post:media:0|1
    Route::post('files/{uuid}/using', 'FilesController@using');//使用
    Route::post('files/{uuid}/del', 'FilesController@del');//删除
    Route::post('files/{uuid}/move', 'FilesController@move');//移动
    //folders
    Route::post('folders', 'FoldersController@store');//添加文件夹
    Route::post('folders/{uuid}', 'FoldersController@edit');//编辑文件夹（修改名称）
    Route::delete('folders/{uuid}', 'FoldersController@destroy');//删除（内部存在文件时不能删除）
});