<?php
namespace app\Admin\controller;

//使用User验证器
use app\Admin\validate\User\User;
use think\Controller;
use think\Cookie;
use think\Db;
use think\Request;
use think\Session;
use app\common\controller\Menus;
class Loreg extends Controller
{
  public function __construct()
  {
    // 继承父类
    parent::__construct();

    $this->AdminModel = model('common/Admin/Admin');
  }
  public function register()
  {
    Session::delete('username');
    Session::delete('login');
    Cookie::delete('username');
    // 判断$_POST有没有东西过来
    // 第一种 使用类的 要加上use think\Request;
    // $request = Request::instance()->post();
    // 第二种 助手函数 就不用use它
    $request = request(); // 助手函数
    // 第三种 
    // $request = $this->request;
    if ($request->post()) {
      // 把post接收到的参数全部放在$data
      $data = $request->post();
      // $data = $request;
      // 验证post的验证码是否跟session的验证码一样
      if (!captcha_check($data['captcha'])) {
        $this->error('验证码错误');
      }
      // 接收的密码
      $password = $data['password'];

      // 密码盐
      $salt = Menus::get_str(4);
      // $salt = get_str(4);

      // 把密码和密码盐拼接一起然后md5加密

      $newPassword = md5($password . $salt);
      $id = $this->AdminModel
        ->field('id')
        ->order('id', 'desc')
        ->limit(1)
        ->find()['id'] + 1;
      // 封装数组
      // input 助手函数
      // $this->error($id);
      $arr = [
        'id' => $id,
        'username' => $data['username'],
        'password' => $newPassword,
        'salt' => $salt
      ];
      $res = Db::name('admin')->insert($arr);
      // $res = Db::execute('insert into think_data (id, name ,status) values (5, "thinkphp",1)');
      if ($res) {
        Session::set('login', '1');
        Session::set('username', $data['username']);
        Cookie::set('username', $data['username']);
        $this->success('注册成功', 'admin/index/index');
      } else {
        $this->error('注册失败');
      }
    }
    // return $this->fetch();
    //$this->view->engine->layout(false);
    return view('index/register');
    //return $this->fetch('html/welcome');
  }


  public function login()
  {

    Session::delete('login');
    Session::delete('username');
    Cookie::delete('username');
    $request = request();
    if ($request->post()) {
      $data = $request->post();
	  $this->back('666',$data);
      if (!captcha_check($data['captcha'])) {
        $this->error('验证码错误');
      }
      $where = [
        'username' => $data['username'],
      ];
      $admin = $this->AdminModel->where($where)->find();
      // halt($admin);
      $repPwd = md5($data['password'] . $admin['salt']);

      if (!$admin || $admin['password'] != $repPwd) {
        $this->error('用户名或者密码错误');
      } else {
        Session::set('username', $data['username']);
        Session::set('login', '1');
        Cookie::set('username', $admin['username']);
        $this->success('登录成功', 'admin/index/index');
      }
    }
    return view('index/login');
  }

}