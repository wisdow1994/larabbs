<?php

return [

    /*
     * 图像剪裁的扩展包
     * composer require intervention/image
     * 生成config/image.php配置文件
     * php artisan vendor:publish --provider="Intervention\Image\ImageServiceProviderLaravel5"
    |--------------------------------------------------------------------------
    | Image Driver
    |--------------------------------------------------------------------------
    |
    | Intervention Image supports "GD Library" and "Imagick" to process images
    | internally. You may choose one of them according to your PHP
    | configuration. By default PHP's "GD Library" implementation is used.
    |
    | Supported: "gd", "imagick"
    |
    */

    'driver' => 'gd'

];
