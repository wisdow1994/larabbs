<?php

/*
 * 安装验证码插件
 * composer require "mews/captcha:~2.0"
 * 生成验证码的配置文件
 * php artisan vendor:publish --provider='Mews\Captcha\CaptchaServiceProvider'
 */

return [

    'characters' => '2346789abcdefghjmnpqrtuxyzABCDEFGHJMNPQRTUXYZ',
    //以下四种是验证码的类型
    'default'   => [
        'length'    => 5,
        'width'     => 120,
        'height'    => 36,
        'quality'   => 90,
    ],

    'flat'   => [
        'length'    => 6,
        'width'     => 160,
        'height'    => 46,
        'quality'   => 90,
        'lines'     => 6,
        'bgImage'   => false,
        'bgColor'   => '#ecf2f4',
        'fontColors'=> ['#2c3e50', '#c0392b', '#16a085', '#c0392b', '#8e44ad', '#303f9f', '#f57c00', '#795548'],
        'contrast'  => -5,
    ],

    'mini'   => [
        'length'    => 3,
        'width'     => 60,
        'height'    => 32,
    ],

    'inverse'   => [
        'length'    => 5,
        'width'     => 120,
        'height'    => 36,
        'quality'   => 90,
        'sensitive' => true,
        'angle'     => 12,
        'sharpen'   => 10,
        'blur'      => 2,
        'invert'    => true,
        'contrast'  => -5,
    ]

];
