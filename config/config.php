<?php

/**
 * 全局配置文件
 */
return [
    //后台登陆密码连续错误次数后禁止登陆
    'adminPassError' => '5',

    //图片上传配置
    'upfile' => [
        //允许的文件大小,单位为B
        'maxSize' => '2000000',
        //上传路径
        'path' => 'uploads',
        //是否水印
        'isWater' => false,
        //水印图片地址
        'water' => 'water.png',
        //水印距离
        'waterSpac' => '5',
    ],
];
