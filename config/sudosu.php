<?php

return [

    /*
     * Sudosu 为了避免开发者在生产环境下误开启此功能，在配置选项 allowed_tlds 里做了域名后缀的限制，
     * tld 为 Top Level Domain 的简写。此处因我们的项目域名为 larabbs.test，故将 test 域名后缀添加到 allowed_tlds 数组中。
     */
    // 允许使用的顶级域名
    'allowed_tlds' => ['dev', 'local', 'test'],

    // 用户模型
    'user_model' => App\Models\User::class

];