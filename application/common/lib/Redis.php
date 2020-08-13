<?php
namespace app\common\lib;

class Redis{
    /**
     * 发送验证码的key前缀
     * @var string
     */
    public static $pre = 'sms_';
	
    // 用户userKey前缀
    public static $userpre = 'user_'; 
    
    /**
     * 生成 redis 验证码的key
     * @param  [type] $phone [description]
     * @return [type]        [description]
     */
    public static function smsKey($phone){
        return self::$pre.$phone;
    }

    public static function userKey($phone){
        return self::$userpre.$phone;
    }
    
}

?>