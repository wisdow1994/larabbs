<?php

namespace App\ViewComposers;

use App\Models\User;
use App\Models\Link;
use Illuminate\View\View;

class ActiveUserComposer{
    /**
     * 将数据绑定到视图
     * @param View $view, User $user
     */
    public function compose(View $view){
        $active_users = (new User())->getActiveUsers();
        $links = (new Link())->getAllCached();

        //第一个参数为要在模板中渲染的对象,绑定到view,需要在ComposerServiceProvider文件设置
        $view->with('active_users',$active_users);
        $view->with('links', $links);


    }
}