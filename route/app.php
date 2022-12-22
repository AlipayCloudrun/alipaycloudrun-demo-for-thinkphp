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
use think\facade\Route;

// 服务访问-获取当前时刻
Route::get('/service', 'index/getNowTime');

// 数据库服务-获取记录信息列表
Route::get('/database/getList', 'index/getList');

// 数据库服务-新增记录
Route::post('/database/addRecord', 'index/addRecord');

// 数据库服务-删除记录
Route::get('/database/deleteRecord', 'index/deleteRecord');

// 缓存服务-redis赋值
Route::get('/redis/set', 'index/setKV');

// 缓存服务-redis取值
Route::get('/redis/get', 'index/getKey');
