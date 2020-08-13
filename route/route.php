<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2018 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

Route::get('think', function () {
    return 'hello,ThinkPHP5!';
});

Route::get('hello/:name', 'index/hello');

Route::miss('index/index'); // MISS 路由
Route::alias('index', 'index/index/index'); // 别名，更简洁
Route::alias('logs', 'index/index/logs');
Route::alias('login', 'index/login/index');
Route::alias('ulogin', 'index/login/login');
Route::alias('out', 'index/login/out');

return [
	
];
