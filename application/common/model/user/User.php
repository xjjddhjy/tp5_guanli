<?php

namespace app\common\model\User;

use think\Model;

// class User extends Model
// {
//     protected $rule = [
//         'username' => 'require|unique',
//         'password' => 'require',
//     ];

//     protected $message = [
//         'password.require' => '密码必填',
//         'username.require' => '用户名必填',
//         'username.unique' => '用户名必须唯一的，该用户已经存在了'
//     ];

//     protected $scene = [
//         'add' => ['username','password']
//     ];
// }
class User extends Model
{
    // 设置表名
    protected $name = 'user';
}

