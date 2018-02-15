<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ComposerServiceProvider extends ServiceProvider
{
    /*
     * 用来注册视图合成器,但是这个服务也需要在config/app.php注册
     */
    public function boot()
    {
        View::composer(['topics._sidebar'],'App\ViewComposers\ActiveUserComposer');
        //可以注册多个view视图文件
//        View::composer('topics._sidebar','App\ViewComposers\ActiveUserComposer');
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
