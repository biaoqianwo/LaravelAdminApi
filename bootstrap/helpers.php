<?php
/**
 * Created by allen <704872038@qq.com>.
 * Date: 2017/8/11
 * Time: 18:26
 */
//加密密码使用（借鉴thinkphp）
function iMd5($str, $key = 'biaoqianwo')
{
    return '' === $str ? '' : md5(sha1($str) . $key);
}

function iEncodeToken($uuid)
{
    $tmp = base64_encode('lixiang80-' . time() . "-{$uuid}");
    return substr($tmp, 10) . substr($tmp, 0, 10);
}

function iDecodeToken($string)
{
    $string = base64_decode(substr($string, -10) . substr($string, 0, -10));
    $array = explode('-', $string);
    return count($array) == 3 && $array[0] == 'lixiang80' ? ['timestamp' => $array[1], 'uuid' => $array[2]] : false;
}

function iValidateString($string, $value)
{
    $value = explode(':', $value);
    $type = $value[0];
    $value = count($value) > 1 ? $value[1] : $value;
    switch ($type) {
        case 'email':
            return filter_var($string, FILTER_VALIDATE_EMAIL);
            break;
        case 'alpha':
            return preg_match('/^[a-zA-Z]+$/i', $string);
            break;
        case 'folder':
            return preg_match('/^[a-zA-Z0-9\/]+$/i', $string);
            break;
        case 'min':
            return strlen($string) >= $value;
            break;
        case 'max':
            return strlen($string) <= $value;
            break;
        default:
            return false;
            break;
    }
}

function iGenerateUuid()
{
    return \Ramsey\Uuid\Uuid::uuid4()->getHex();
}

function iCheckFile(\Illuminate\Http\UploadedFile $file)
{
    $ext = $file->getClientOriginalExtension();
    switch ($ext) {
        case 'jpeg':
        case 'jpg':
        case 'png':
        case 'gif':
        case 'ico':
            return iCheckImg($file);
            break;
        case 'txt':
        case 'md':
        case 'doc':
        case 'docx':
        case 'xls':
        case 'xlsx':
        case 'ppt':
        case 'pptx':
            return iCheckDocument($file);
            break;
        default:
            return false;
    }

}

function iCheckImg(\Illuminate\Http\UploadedFile $file)
{
    if ($file->getSize() > 100000) {
        exit('file max size is 100000 byte');
    }

    list($width, $height) = getimagesize($file);
    if ($width > 2000) {
        exit('file max width is 2000px');
    }
    if ($height > 3000) {
        exit('file max height is 3000px');
    }
    return true;
}

function iCheckDocument(\Illuminate\Http\UploadedFile $file)
{
    return true;
}


function iGenerateFileUrl($dir, $name = null, $ext = null)
{
    return !$name ? null : config('app.url') . 'storage' . '/' . $dir . '/' . $name . '.' . $ext;
}

/**
 * @param $class
 * @param $function
 * @return string
 */
function generatePermissionName($class, $function)
{
    //App\Models\ArticleCate==>ArticleCate
    return array_last(explode('\\', $class)) . '.' . $function;
}
