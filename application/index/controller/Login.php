<?php
namespace app\index\controller;
use think\Controller;
use think\facade\Session; // 使用Session类
use app\common\lib\Util;
use think\Model;
use think\Db;

class Login extends Controller {
    
    // 登录页面
    public function index(){
        $res = Util::isLogin();
        if($res){ // 已登录
            $index_url = url('index/index/index', 'time='.time());
            return $this->redirect($index_url); // 跳转至首页
        }else{ // 未登录
            //$get_captcha = url('index/register/getcaptcha', 'time='.time());
            $post_url = url('index/login/login', 'time='.time());
            //$this->assign('captcha', $get_captcha); // 验证码        
            $this->assign('post_url', $post_url); // 提交地址  
            $nav['forget_pw'] = '#';
            $nav['register'] = url('index/register/index', 'time='.time());
            $this->assign('nav', $nav); 
            
            $root_path = config('user.host');
            $this->assign('root_path', $root_path);
            
            // 获取部门数据
            $sql = " SELECT id,dep FROM work_department WHERE status = 1";
            $dep_info = Db::query($sql);
            $this->assign('dep_info', $dep_info);

            $login_url = url('index/login/login'); // 登录验证地址
            $this->assign('login_url', $login_url);

            $request = request();
            // 判断是否是手机端
            if($request->isMobile){
                return view('login');
            }else{
               // return view('login_pc'); // pc端 
               return view('login'); // 不分手机还是电脑端
            }
        }
    }


    // 提交用户名和密码登录
    public function login(){
        $request = request();
        if(!$request->isPost()){
            return Util::show(config('code.error'), '请登录');
        }
        $post = $request->post();
        // var_dump($post);
        if(!$post['username']){
            return Util::show(config('code.error'), '请输入用户名');
        }
        if(!$post['password']){
            return Util::show(config('code.error'), '请输入密码');
        }
        if(!$post['dep']){
            return Util::show(config('code.error'), '请选择部门');
        }

        $error  = Session::get('login_error') ? : ['num'=>0,'time'=>time()];
        if($error['num'] >=5 && $error['time'] > strtotime('- 5 minutes')){
            return Util::show(config('code.error'), '错误次数过多,请稍候再试!');
        }
        
        $username = $post['username'];
        $password = Util::setPassword($post['password']);
        $dep_id = intval($post['dep']);

        //检验帐号密码
        $res = model('User')->field('id,name,password,station,is_manger,status')->where(['name'=>$username, 'dep_id'=>$dep_id])->find();
        $status = config('user.user_status_normal');
        if(!empty($res) && ($res['status'] !== $status)){
            $error['num'] += 1;
            $error['time'] = time();
            Session::set('login_error', $error);
            return Util::show(config('code.error'), '该用户已被禁用');
        }elseif(!empty($res) && ($res['password'] !== $password)){
            $error['num'] += 1;
            $error['time'] = time();
            Session::set('login_error', $error);
            return Util::show(config('code.error'), '密码错误');
        }elseif(empty($res)){
            $error['num'] += 1;
            $error['time'] = time();
            Session::set('login_error', $error);
            return Util::show(config('code.error'), '该用户不存在');
        }else{
            Session::set('login_error', null);
            $key = config('redis.login_key');
            $value = [
                'id' => $res['id'],
                'username' => $res['name'],
                'dep_id' => $dep_id,
                'station' => $res['station'],
                'is_manger' => $res['is_manger'],
                'status' => $res['status'],
                'login_time' => time(),
            ];
            Session::set($key, $value);
            
            // 更新用户表 最后登录时间 
            $data = [
                'last_login_ip' => request()->ip(),
                'last_login_time' => time()
            ];
            $param = ['id' => $res['id']];
            Model('User')->updateUserData($data, $param);
            $index_url = url('index/index/index', 'time='.time());
            return Util::show(config('code.success'), '登录成功', ['url'=>$index_url]); // 跳转至首页
        }
	}


    // 退出登录
    public function out(){
        $key = config('redis.login_key');
        Session::set($key, null);
        $index_url = url('index/login/index', 'time='.time());
        return $this->redirect($index_url); // 跳转至登录页
    }
   
}


?>