<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
		 \App\Models\Reply::class => \App\Policies\ReplyPolicy::class,
		 \App\Models\Topic::class => \App\Policies\TopicPolicy::class,
        'App\Model' => 'App\Policies\ModelPolicy',
        \App\Models\User::class  => \App\Policies\UserPolicy::class,//在此处注册自定义的授权认证策略
    ];

    public function boot()
    {
        $this->registerPolicies();
        /*
         * Horizon 控制面板页面的路由是 /horizon ，默认只能在 local 环境中访问仪表盘。
         * 我们可以使用 Horizon::auth 方法定义更具体的访问策略。
         * auth 方法能够接受一个回调函数，此回调函数需要返回 true 或 false ，
         * 从而确认当前用户是否有权限访问 Horizon 仪表盘。接下来我们定义 /horizon 的访问权限，只有 站长 才有权限查看：
         */

        \Horizon::auth(function ($request) {
            // 是否是站长
            return \Auth::user()->hasRole('Founder');
        });
    }
}
