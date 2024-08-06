<?php
// +----------------------------------------------------------------------
// | 路由设置
// +----------------------------------------------------------------------

use think\facade\Route;

// 定义新的路由规则
Route::get('/elastic/scaling/cpu/update', 'app\controller\ElasticScalingController@memoryUpdate');
Route::get('/elastic/scaling/cpu/clean', 'app\controller\ElasticScalingController@memoryClean');

return [
    // pathinfo分隔符
    'pathinfo_depr'         => '/',
    'url_html_suffix'       => 'html',
    'url_common_param'      => true,
    'url_lazy_route'        => false,
    'url_route_must'        => false,
    'route_rule_merge'      => false,
    'route_complete_match'  => false,
    'controller_layer'      => 'controller',
    'empty_controller'      => 'Error',
    'controller_suffix'     => false,
    'default_route_pattern' => '[\w\.]+',
    'request_cache_key'     => false,
    'request_cache_expire'  => null,
    'request_cache_except'  => [],
    'default_controller'    => 'Index',
    'default_action'        => 'index',
    'action_suffix'         => '',
    'default_jsonp_handler' => 'jsonpReturn',
    'var_jsonp_handler'     => 'callback',
];