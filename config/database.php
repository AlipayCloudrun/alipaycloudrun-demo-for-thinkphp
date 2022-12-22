<?php

return [
    // 默认使用的数据库连接配置
    'default' => env('database.driver', 'mysql'),
    // 自定义时间查询规则
    'time_query_rule' => [],

    // 自动写入时间戳字段
    // true为自动识别类型 false关闭
    // 字符串则明确指定时间字段类型 支持 int timestamp datetime date
    'auto_timestamp' => true,

    // 时间字段取出后的默认时间格式
    'datetime_format' => 'Y-m-d H:i:s',

    // 时间字段配置 配置格式：create_time,update_time
    'datetime_field' => '',
    // 数据库连接配置信息
    'connections' => [
        'mysql' => [
            // 数据库类型
            'type' => 'mysql',
            // 服务器地址
            'hostname' => getenv('DATABASE_HOST') == null ? '127.0.0.1' : preg_split('/:/', getenv('DATABASE_HOST'))[0],
            // 服务器端口
            'hostport' => getenv('DATABASE_HOST') == null ? '3306' : preg_split('/:/', getenv('DATABASE_HOST'))[1],
            // 用户名
            'username' => getenv('DATABASE_USERNAME') == null ? 'root' : getenv('DATABASE_USERNAME'),
            // 密码
            'password' => getenv('DATABASE_PASSWORD') == null ? '123456' : getenv('DATABASE_PASSWORD'),
            // 数据库名
            'database' => getenv('DATABASE_NAME') == null ? 'test' : getenv('DATABASE_NAME'),
        ],
        // 更多的数据库配置信息
    ],
];
