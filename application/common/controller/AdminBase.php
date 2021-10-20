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
class AdminBase extends Controller
{
    public  function _initialize()
    {
        $login = Session::get('login');
        if($login){
            if($login != 1){
                $this->error('请登录','admin/loreg/login');
            }
        }else{
            $this->error('请登录','admin/loreg/login');
        }
    }

}