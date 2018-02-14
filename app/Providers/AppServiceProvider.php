<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
	{
		\App\Models\User::observe(\App\Observers\UserObserver::class);
		\App\Models\Reply::observe(\App\Observers\ReplyObserver::class);
		\App\Models\Topic::observe(\App\Observers\TopicObserver::class);

        \Carbon\Carbon::setLocale('zh');//时间戳显示的中文化支持
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {

        /*
         * sudo-su 本地开发环境下的用户切换工具，来提高我们的效率
         * composer require "viacreative/sudo-su:~1.1"
         * 服务注册
         * php artisan vendor:publish --provider="VIACreative\SudoSu\ServiceProvider"
         * 会生成：/public/sudo-su 前端 CSS 资源存放文件夹；config/sudosu.php 配置信息文件
         */
        if (app()->isLocal()) {
            $this->app->register(\VIACreative\SudoSu\ServiceProvider::class);
        }//
    }
}
