<?php
namespace app\common\controller;

use think\Controller;
// Session类
use think\Session;

// 继承了tp的控制器
/* 
    公共控制器为了我们有一些代码是所有控制器都要用
    防止代码重复性

    为什么继承tp的控制器
    因为我们继承tp的控制就不用写其他类，一些方法，直接可以用tp的

*/
class Menus
{

    public static function get_str($length = 4)
  {
    $chars = '1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $size = str_shuffle($chars); // 随机打乱字符串
    $str = substr($size, 0, $length);
    return $str;
  }
}