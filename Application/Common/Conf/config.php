<?php
return array (
    'MYSQL' =>
    array (
        'host' => 'localhost',
        'user' => 'tblog',
        'pass' => '123456',
        'data' => 'tblog',
    ),
    'DB_TYPE'   => 'mysql', // 数据库类型
    'DB_HOST'   => 'localhost', // 服务器地址
    'DB_NAME'   => 'tblog', // 数据库名
    'DB_USER'   => 'tblog', // 用户名
    'DB_PWD'    => '123456', // 密码
    'DB_PORT'   => 3306, // 端口
    'DB_PARAMS' =>  array(), // 数据库连接参数
    'DB_PREFIX' => 'blog_', // 数据库表前缀
    'DB_CHARSET'=> 'utf8', // 字符集
    'DB_DEBUG'  =>  TRUE, // 数据库调试模式 开启后可以记录SQL日志

    'DB_CONFIG1' => 'mysql://tblog:123456@localhost:3306/tblog#utf8',

    'URL_PARAMS_BIND_TYPE' => 1,

);
