<?php
namespace app\common\lib;
use think\facade\Session; // 使用Session类
use think\facade\Env;

class Util{
	/**
     * api 输出格式
     * @param  [type] $status  [description]
     * @param  string $message [description]
     * @param  [type] $data    [description]
     * @return [type]          [description]
     */
    public static function show($status, $message='', $data=[]){
        $result = [ 
            'status' => $status,
            'message' => $message,
            'data' => $data,
        ];
        echo json_encode($result);
    }


    /**
     * 设置用户密码
     * @param [type] $str [description]
     * return [type] string
     */
    public static function setPassword($str){
        $key = config('user.user_prefix').$str;
        return md5(md5($key));
    }


    /**
     * 判断用户是否登录
     * return boolean  [true or false]
     */
    public static function isLogin(){
        $res = Session::get(config('redis.login_key'));
        if($res){
            return true;
        }else{
            return false;
        }
    }

    /**
     * 登录key
     * @param  [string] $username [用户名]
     * @return [string] key
     */
    public static function loginkey($username){
        $str = congfig('redis.login_key').$username;
        return $str;
    }
    

    /**
     * 数据写入日志
     * @param  [string] $file [文件具体路径，包含文件名]
     * @param  [string] $data [要写入的数据]
     * @return [type]       [description]
     */
    public static function writeLog($file, $data){
        $root_path = Env::get('root_path'); // 获取根目录
        $dir = pathinfo($file, PATHINFO_DIRNAME);
        $dir_arr = explode('/', $dir);
        $file_path = '';
        $str = '';
        foreach($dir_arr as $v){
            $str .= $v.'/';
            $file_path = $root_path.$str;
            if(!file_exists($file_path)){ // 没有该目录则创建
                mkdir($file_path, 0777);
            }
        }
        $logdata = $data."\r\n";
        file_put_contents($root_path.$file, $logdata, FILE_APPEND | LOCK_EX); //写入日志文件
    }

    
    /**
     * [checkFilePath 检测文件路径，没有则创建] mkdir($file_path, 0777, true)
     * @param  [string] $file [文件路径]
     * @return [type]       [description]
     */
    public static function checkFilePath($file){
        $root_path = Env::get('root_path'); // 获取根目录
        $dir = pathinfo($file, PATHINFO_DIRNAME);
        $dir_arr = explode('/', $dir);
        $file_path = '';
        $str = '';
        foreach($dir_arr as $v){
            $str .= $v.'/';
            $file_path = $root_path.$str;
            if(!file_exists($file_path)){ // 没有该目录则创建
                mkdir($file_path, 0777);
            }
        }
    }
    
}

?>