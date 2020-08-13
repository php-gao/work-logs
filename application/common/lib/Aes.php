<?php
/*
    一般来说AES加密需要mcrypt扩展的支持，windows的环境下PHP都自带了这个扩展，
    而linux则需要自己安装这个扩展，但是在PHP7.2以后mcrypt扩展从PHP核心代码中移除
    
    所以如果使用PHP7.2之后的版本是无法通过mcrypt扩展实现Aes加密的，
    那么如何PHP7.2之后如何进行Aes加密呢？
    官方手册上说mcrypt被OpenSSL取代，所以我们可以通过OpenSSL代替
    
    http://www.pianshen.com/article/386272927/
*/   

namespace app\common\lib;
/**
 * aes 加密 解密类库
 *
 */
class Aes {
 
    private $hex_iv = 'qwertyuiopasdfdghjkl';
    private $key = 'zxcvbnm';
 
    function __construct() {
        //$this->key = $key;
        $this->key = hash('sha256', $this->key, true);
    }

    public static function encrypt($input) { // 加密
        $aes = new Aes();
        $data = @openssl_encrypt($input, 'AES-256-CBC', $aes->key, OPENSSL_RAW_DATA, $aes->hexToStr($aes->hex_iv));
        $data = base64_encode($data);
        return $data;
    }
 
    public static function decrypt($input){ // 解密
        $aes = new Aes();
        $decrypted = @openssl_decrypt(base64_decode($input), 'AES-256-CBC', $aes->key, OPENSSL_RAW_DATA, $aes->hexToStr($aes->hex_iv));
        return $decrypted;
    }
    
    private function addpadding($string, $blocksize = 16) {
        $len = strlen($string);
        $pad = $blocksize - ($len % $blocksize);
        $string .= str_repeat(chr($pad), $pad);
        return $string;
    }
 
    private function strippadding($string) {
        $slast = ord(substr($string, -1));
        $slastc = chr($slast);
        $pcheck = substr($string, -$slast);
        if (preg_match("/$slastc{" . $slast . "}/", $string)) {
            $string = substr($string, 0, strlen($string) - $slast);
            return $string;
        } else {
            return false;
        }
    }
 
    function hexToStr($hex){
        $string='';
        for ($i=0; $i < strlen($hex)-1; $i+=2){
            $string .= chr(hexdec($hex[$i].$hex[$i+1]));
        }
        return $string;
    }
}