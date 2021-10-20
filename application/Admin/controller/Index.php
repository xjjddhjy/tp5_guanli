<?php

namespace app\Admin\controller;


use app\common\controller\AdminBase;
use app\common\controller\Menus;
use think\Controller;
use think\Cookie;
use think\Db;
use think\Request;
use think\Session;

// session_start();

//使用User验证器
// use think\Controller;

class Index extends AdminBase
{

  public function __construct()
  {
    // 继承父类
    parent::__construct();
    // 助手函数model调用Admin模型
    $this->AdminModel = model('common/Admin/Admin');
    $this->AdminModel2 = model('common/User/User');
  }
  public  function adminname()
  {
    $login = Session::get('login');
    $username = Session::get('username');
    return $username;
  }
  
  public function upload()
  {
      // 接收前端的请求  通过字段名来判断
      $avatar = request()->file('avatar');
      // 思路：把修改图片的功能放在这里
      // 如果这条数据本来就有图片 当重新上传一个新的图片时，把旧的图片删除
      $id = request()->post('id');
      if($id){
          // 上传过来的id查询出来相应的数据
          $admin = $this->AdminModel->where('id',$id)->find();
          // $filename = $info->getSaveName();
          // 拿查询的数据里的avatar值拼接出来一个文件路径
          $path = ROOT_PATH . 'public' . DS .'static' . DS . 'admin'. DS . 'uploads' .DS. $admin['avatar'];
          // 判断文件是否存在
          if(file_exists($path) && !empty($admin['avatar'])){
            @unlink($path);
          }
          // 上传的代码
          $info = $avatar->move(ROOT_PATH . 'public' . DS .'static' . DS . 'admin'. DS . 'uploads');

          if($info){
              // 获取到文件名
              $file = $info->getSaveName();
              // 把文件名更新到数据库里面
              $res = $this->AdminModel->where('id',$id)->update(['avatar' => $file]);
              // 判断是否更新成功
              if($res){
                  $data = [
                      'msg' => '上传成功',
                      'code' => 0,
                      'filename' => $file
                  ];
                  // 把数组转化json字符串
                  echo json_encode($data);
                  exit;
              }else {
                  $error = $avatar->getError();
                  // 接口的返回信息
                  $data = [
                      'msg' => $error,
                      'code' => 1,
                  ];
                  // 把数组转化json字符串
                  echo json_encode($data);
                  exit;
              }
          }
      }else{
          $info = $avatar->move(ROOT_PATH . 'public' . DS .'static' . DS . 'admin'. DS . 'uploads');
          
          if($info){
              // 输出文件后缀 jpg
              // $a =  $info->getExtension();
              // echo json_encode($a);
              // 输出 带日期文件夹以及图片名 推荐
              $filename =  $info->getSaveName();
              // echo $b;
              // 输出 文件名
              // $c = $info->getFilename();
              // echo $c;
              // 接口的返回信息
              $data = [
                  'msg' => '上传成功',
                  'code' => 0,
                  'filename' => $filename
              ];
              // 把数组转化json字符串
              echo json_encode($data);
              exit;
              
          }else{
              $error = $avatar->getError();
              // 接口的返回信息
              $data = [
                  'msg' => $error,
                  'code' => 1,
              ];
              // 把数组转化json字符串
              echo json_encode($data);
              exit;
          }
      }
      
  }
  public function has($has)
  {
    ////$this->view->engine->layout(false);
    return $has;
  }

  public function index()
  {
    ////$this->view->engine->layout(false);
    //(new AdminBase)->_initialize();
    $this->assign('domain', $this->request->url(true));
    return view('index/index');
    //     return $this->fetch('index');
  }
  public function welcome()
  {
    //$this->view->engine->layout(false);
    $this->assign('admin', Session::get('username'));
    return view('html/welcome');
    //return $this->fetch('html/welcome');
  }
  public function unicode()
  {
    //$this->view->engine->layout(false);
    return view('html/unicode');
    //return $this->fetch('html/welcome');
  }
  public function form1()
  {
    //$this->view->engine->layout(false);
    return view('html/form1');
    //return $this->fetch('html/welcome');
  }
  public function form2()
  {
    //$this->view->engine->layout(false);
    return view('html/form2');
    //return $this->fetch('html/welcome');
  }
  public function buttons()
  {
    //$this->view->engine->layout(false);
    return view('html/buttons');
    //return $this->fetch('html/welcome');
  }
  public function nav()
  {
    //$this->view->engine->layout(false);
    return view('html/nav');
    //return $this->fetch('html/welcome');
  }
  public function tab()
  {
    //$this->view->engine->layout(false);
    return view('html/tab');
    //return $this->fetch('html/welcome');
  }
  public function progress_bar()
  {
    //$this->view->engine->layout(false);
    return view('html/progress-bar');
    //return $this->fetch('html/welcome');
  }
  public function panel()
  {
    //$this->view->engine->layout(false);
    return view('html/panel');
    //return $this->fetch('html/welcome');
  }
  public function badge()
  {
    //$this->view->engine->layout(false);
    return view('html/badge');
    //return $this->fetch('html/welcome');
  }
  public function timeline()
  {
    //$this->view->engine->layout(false);
    return view('html/timeline');
    //return $this->fetch('html/welcome');
  }
  public function table_element()
  {
    //$this->view->engine->layout(false);
    return view('html/table-element');
    //return $this->fetch('html/welcome');
  }
  public function anim()
  {
    //$this->view->engine->layout(false);
    return view('html/anim');
    //return $this->fetch('html/welcome');
  }
  // public function upload()
  // {
  //   //$this->view->engine->layout(false);
  //   return view('html/upload');
  //   //return $this->fetch('html/welcome');
  // }
  public function page()
  {
    //$this->view->engine->layout(false);
    return view('html/page');
    //return $this->fetch('html/welcome');
  }
  public function cate()
  {
    //$this->view->engine->layout(false);
    return view('html/cate');
    //return $this->fetch('html/welcome');
  }
  public function carousel()
  {
    //$this->view->engine->layout(false);
    return view('html/carousel');
    //return $this->fetch('html/welcome');
  }
  public function city()
  {
    //$this->view->engine->layout(false);
    return view('html/city');
    //return $this->fetch('html/welcome');
  }
  public function grid()
  {
    //$this->view->engine->layout(false);
    return view('html/grid');
    //return $this->fetch('html/welcome');
  }
  public function welcome2()
  {
    //$this->view->engine->layout(false);
    return view('html/welcome2');
    //return $this->fetch('html/welcome');
  }
  public function order_list()
  {
    //$this->view->engine->layout(false);
    return view('html/order-list');
    //return $this->fetch('html/welcome');
  }
  public function admin_add()
  {
    $request = request();
    if(request()->file('avatar')){
     
      $avatar = request()->file('avatar');
      $info = $avatar->move(ROOT_PATH . 'public' . DS .'static' . DS . 'admin'. DS . 'uploads');       
      if($info){
          // 输出文件后缀 jpg
          // $a =  $info->getExtension();
          // echo json_encode($a);
          // 输出 带日期文件夹以及图片名 推荐
          $filename =  $info->getSaveName();   
          if ($request->post()) {
            // 接收表单的请求
            $data = $request->post();
            // 生成密码盐
              $salt=Menus::getStr(4);


      
            // 赋值
            // $data = $data['field'];
            // 接收的密码和密码盐拼接出来的新密码
            $pwd = md5($data['password'] . $salt);
            // 封装数组
            // 'nickname' => $data['nickname'],
            $id = $this->AdminModel
              ->field('id')
              ->order('id', 'desc')
              ->limit(1)
              ->find()['id'] + 1;
            $result = [
              'id' => $id,
              'username' => $data['username'],
              'password' => $pwd,
              'salt'     => $salt,
              'avatar' => $filename
            ];
            // 插入数据
            $res = $this->AdminModel->insert($result);
      
            if ($res) {
              $data = [
                'code' => 0,
                'msg'  => '增加成功',
              ];
              echo json_encode($data);
              exit;
            } else {
              @unlink(ROOT_PATH . 'public' . DS .'static' . DS . 'admin'. DS . 'uploads/'.$filename);
              $data = [
                'code' => 1,
                'msg'  => '增加失败',
              ];
              echo json_encode($data);
              exit;
            }
          }   
      }else{
  
      }
    }

    // 先判断是否有post请求
    



    return view('html/admin-add');
  }
  public function admin_list()
  {
    //$this->view->engine->layout(false);
    // $DB = new  DB('localhost', 'root', 'root', 'student_manager');
    // $admin = $DB->select('*')->from('administrator')->getAll();
    // $admin = Db::name('administrator')->where('id', 18)->select();
    // $admin = $this->AdminModel->select();
    $adminlist = $this->AdminModel->paginate(5);
    $page = $adminlist->render();
    $this->assign('admin', $adminlist);
    $this->assign('page', $page);
    return view('html/admin-list');
    //return $this->fetch('html/welcome');
  }
  public function admin_list_delAll()
    {
        $arr = request()->post();
        // var_dump($arr);exit;
        if($arr){
            $data = $arr['id'];
            // dump($data);
            $str = implode(',',$data);
            foreach($data as $key=>$id){
              $admin = $this->AdminModel->where('id',$id)->find();
            
              // 拼接路径  2668e3b25c4d11538a9aae62e6f3751e.jpg
              $path = ROOT_PATH . 'public' . DS .'static' . DS . 'admin'. DS . 'uploads' .DS. $admin['avatar'];
              // 判断文件是否存在
              if(file_exists($path) && !empty($admin['avatar'])){
                  @unlink($path);
              }
            }



            // dump($str);
            $res = $this->AdminModel::destroy($str);
            if($res){
                $data = [
                    'code' => 0,
                    'msg' => '删除成功',
                ];
                echo json_encode($data);
                exit;
            }
        }
    }
  public function admin_list_del()
    {
        $id = request()->post('id');
        if($id){
            // 从数据表查询出来该条数据
            $admin = $this->AdminModel->where('id',$id)->find();
            
            // 拼接路径  2668e3b25c4d11538a9aae62e6f3751e.jpg
            $path = ROOT_PATH . 'public' . DS .'static' . DS . 'admin'. DS . 'uploads' .DS. $admin['avatar'];
            // 判断文件是否存在
            if(file_exists($path) && !empty($admin['avatar'])){
                @unlink($path);
            }


            // 执行删除操作
            $res = $this->AdminModel->where('id',$id)->delete();
            if($res){
                $data = [
                    'code' => 0,
                    'msg' => '删除成功'
                ];
                echo json_encode($data);
                exit;
            }
        }
    }

  public function admin_edit()
  {
    if (Request::instance()->isGet()) {
      $data = request()->get();
      $id = $data['id'];
      $username = $data['username'];

      $this->assign('id', $id);
      $this->assign('username', $username);
      return view('html/admin-edit');
    } else {
      $data = request()->post();
      $data = $data['field'];
      $id = $data['id'];
      $password = $data['password'];
      $username = $data['username'];
      $avatar =$data['photo'] ;
      // $salt = $this->AdminModel
      //   ->field('salt')->where('id', $id)
      //   ->find()['salt'];
      $salt = Menus::get_str(4);
      // $salt=get_str(4);
      $arr = [
        'id' => $id,
        'username' => $username,
        'password' => md5($password . $salt),
        'salt' => $salt,
        'avatar' => $avatar
      ];
      if ($password && $username) {
        $this->AdminModel
          ->where('id', $id)
          ->update($arr);
        $data = [
          'code' => 0,
          'msg'  => '修改成功',
        ];
        echo json_encode($data);
      }
    }

  }

  //
  public function user_add()
  {
    $request = request();
    if(request()->file('avatar')){
     
      $avatar = request()->file('avatar');
      $info = $avatar->move(ROOT_PATH . 'public' . DS .'static' . DS . 'admin'. DS . 'uploads');       
      if($info){
          // 输出文件后缀 jpg
          // $a =  $info->getExtension();
          // echo json_encode($a);
          // 输出 带日期文件夹以及图片名 推荐
          $filename =  $info->getSaveName();   
          if ($request->post()) {
            // 接收表单的请求
            $data = $request->post();
            // 生成密码盐
            $salt = Menus::get_str(4);
      
            // 赋值
            // $data = $data['field'];
            // 接收的密码和密码盐拼接出来的新密码
            $pwd = md5($data['password'] . $salt);
            // 封装数组
            // 'nickname' => $data['nickname'],
            $id = $this->AdminModel2
              ->field('id')
              ->order('id', 'desc')
              ->limit(1)
              ->find()['id'] + 1;
            $result = [
              'id' => $id,
              'username' => $data['username'],
              'password' => $pwd,
              'salt'     => $salt,
              'avatar' => $filename
            ];
            // 插入数据
            $res = $this->AdminModel2->insert($result);
      
            if ($res) {
              $data = [
                'code' => 0,
                'msg'  => '增加成功',
              ];
              echo json_encode($data);
              exit;
            } else {
              @unlink(ROOT_PATH . 'public' . DS .'static' . DS . 'admin'. DS . 'uploads/'.$filename);
              $data = [
                'code' => 1,
                'msg'  => '增加失败',
              ];
              echo json_encode($data);
              exit;
            }
          }   
      }else{
  
      }
    }

    // 先判断是否有post请求
    



    return view('html/user-add');
  }
  public function user_list()
  {
    //$this->view->engine->layout(false);
    // $DB = new  DB('localhost', 'root', 'root', 'student_manager');
    // $admin = $DB->select('*')->from('administrator')->getAll();
    // $admin = Db::name('administrator')->where('id', 18)->select();
    $admin = $this->AdminModel2->select();
    $adminlist = $this->AdminModel2->paginate(5);
    $page = $adminlist->render();
    $this->assign('admin', $adminlist);
    $this->assign('page', $page);
    return view('html/user-list');
    //return $this->fetch('html/welcome');
  }
  public function user_list_delAll()
    {
        $arr = request()->post();
        // var_dump($arr);exit;
        if($arr){
            $data = $arr['id'];
            // dump($data);
            $str = implode(',',$data);
            foreach($data as $key=>$id){
              $admin = $this->AdminModel2->where('id',$id)->find();
            
              // 拼接路径  2668e3b25c4d11538a9aae62e6f3751e.jpg
              $path = ROOT_PATH . 'public' . DS .'static' . DS . 'admin'. DS . 'uploads' .DS. $admin['avatar'];
              // 判断文件是否存在
              if(file_exists($path) && !empty($admin['avatar'])){
                  @unlink($path);
              }
            }



            // dump($str);
            $res = $this->AdminModel2::destroy($str);
            if($res){
                $data = [
                    'code' => 0,
                    'msg' => '删除成功',
                ];
                echo json_encode($data);
                exit;
            }
        }
    }
  public function user_list_del()
    {
        $id = request()->post('id');
        if($id){
            // 从数据表查询出来该条数据
            $admin = $this->AdminModel2->where('id',$id)->find();
            
            // 拼接路径  2668e3b25c4d11538a9aae62e6f3751e.jpg
            $path = ROOT_PATH . 'public' . DS .'static' . DS . 'admin'. DS . 'uploads' .DS. $admin['avatar'];
            // 判断文件是否存在
            if(file_exists($path) && !empty($admin['avatar'])){
                @unlink($path);
            }


            // 执行删除操作
            $res = $this->AdminModel2->where('id',$id)->delete();
            if($res){
                $data = [
                    'code' => 0,
                    'msg' => '删除成功'
                ];
                echo json_encode($data);
                exit;
            }
        }
    }

  public function user_edit()
  {
    if (Request::instance()->isGet()) {
      $data = request()->get();
      $id = $data['id'];
      $username = $data['username'];

      $this->assign('id', $id);
      $this->assign('username', $username);
      return view('html/user-edit');
    } else {
      $data = request()->post();
      $data = $data['field'];
      $id = $data['id'];
      $password = $data['password'];
      $username = $data['username'];
      $avatar =$data['photo'] ;
      // $salt = $this->AdminModel
      //   ->field('salt')->where('id', $id)
      //   ->find()['salt'];
      $salt = Menus::get_str(4);
      // $salt=get_str(4);
      $arr = [
        'id' => $id,
        'username' => $username,
        'password' => md5($password . $salt),
        'salt' => $salt,
        'avatar' => $avatar
      ];
      if ($password && $username) {
        $this->AdminModel2
          ->where('id', $id)
          ->update($arr);
        $data = [
          'code' => 0,
          'msg'  => '修改成功',
        ];
        echo json_encode($data);
      }
    }

  }
  //
  public function admin_role()
  {
    //$this->view->engine->layout(false);
    return view('html/admin-role');
    //return $this->fetch('html/welcome');
  }
  public function admin_cate()
  {
    //$this->view->engine->layout(false);
    return view('html/admin-cate');
    //return $this->fetch('html/welcome');
  }
  public function admin_rule()
  {
    //$this->view->engine->layout(false);
    return view('html/admin-rule');
    //return $this->fetch('html/welcome');
  }
  public function member_del()
  {
    //$this->view->engine->layout(false);
    return view('html/member-del');
    //return $this->fetch('html/welcome');
  }
  public function echarts1()
  {
    //$this->view->engine->layout(false);
    return view('html/echarts1');
    //return $this->fetch('html/welcome');
  }
  public function echarts2()
  {
    //$this->view->engine->layout(false);
    return view('html/echarts2');
    //return $this->fetch('html/welcome');
  }
  public function echarts3()
  {
    //$this->view->engine->layout(false);
    return view('html/echarts3');
    //return $this->fetch('html/welcome');
  }
  public function echarts4()
  {
    //$this->view->engine->layout(false);
    return view('html/echarts4');
    //return $this->fetch('html/welcome');
  }
  public function echarts5()
  {
    //$this->view->engine->layout(false);
    return view('html/echarts5');
    //return $this->fetch('html/welcome');
  }
  public function echarts6()
  {
    //$this->view->engine->layout(false);
    return view('html/echarts5');
    //return $this->fetch('html/welcome');
  }
  public function echarts7()
  {
    //$this->view->engine->layout(false);
    return view('html/echarts5');
    //return $this->fetch('html/welcome');
  }
  public function echarts8()
  {
    //$this->view->engine->layout(false);
    return view('html/echarts5');
    //return $this->fetch('html/welcome');
  }
}
