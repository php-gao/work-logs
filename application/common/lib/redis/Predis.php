<?php
namespace app\common\lib\redis;

class Predis{
    public $redis = '';

    // 定义单例模式的变量   
    private static $_instance = null;
	
    public static function getInstance(){
        if(empty(self::$_instance)){
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    private function __construct(){
        $this->redis = new \Redis();
        $result = $this->redis->connect(config('redis.host'), config('redis.port'), config('redis.timeOut'));
        if($result === false){
            throw new \Exception('Redis connect error');
        }
    }

    /**
     * [set description]
     * @param [type]  $key   [description]
     * @param [type]  $value [description]
     * @param integer $time  [description]
     */
    public function set($key, $value, $time=0){
        if(!$key){
            return '';
        }
        if(is_array($value)){
            $value = json_encode($value);
        }
        if(!$time){
            return  $this->redis->set($key, $value);
        }
        return $this->redis->setex($key, $time, $value);
    }
    
    /**
     * [get description]
     * @param  [type] $key [description]
     * @return [type]      [description]
     */
    public function get($key){
        if(!$key){
            return '';
        }
        return $this->redis->get($key);
    }

    /**
     * [del description]
     * @param  [type] $key [description]
     * @return [type]      [description]
     */
    public function del($key){
        if(!$key){
            return '';
        }
        return $this->redis->del($key);
    }

    /**
     * 有序集合 smembers
     * @param  [type] $key   [description]
     * @param  [type] $value [description]
     * @return [type]        [description]
     */
    public function sAdd($key, $value){
        if(!$key){
            return '';
        }
        return $this->redis->sAdd($key, $value);
    }

    /**
     * 删除有序集合中的元素
     * @param  [type] $key   [description]
     * @param  [type] $value [description]
     * @return [type]        [description]
     */
    public function sRem($key, $value){
        if(!$key){
            return '';
        }
        return $this->redis->sRem($key, $value);
    }

    /**
     * 获取 redis 集合元素
     * @param  [type] $key [description]
     * @return [type]      [description]
     */
    public function sMembers($key){
        if(!$key){
            return '';
        }
        return $this->redis->sMembers($key);
    }

    /**
     * 魔术方法 __call
     * 当调用一个没有在类中声明的方法时，
     * 可以调用__call()方法代替声明一个方法。
     * 接受方法名和数组作为参数。
     * @param  [type] $name      [description]
     * @param  [type] $arguments [description]
     * @return [type]            [description]
     */
    public function __call($method, $arguments){
        if(!$arguments){
            return '';
        }
        /*
        if(count($arguments) == 1){
            return $this->redis->$method($arguments[0]);
        }elseif(count($arguments) == 2){
            return $this->redis->$method($arguments[0], $arguments[1]);
        }
        */
        return $this->redis->$method(...$arguments);      
    }
}
