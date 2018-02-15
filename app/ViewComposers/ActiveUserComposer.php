<?php

namespace App\ViewComposers;

use App\Models\User;
use Illuminate\View\View;

class ActiveUserComposer{
    /**
     * 将数据绑定到视图
     * @param View $view, User $user
     */
    public function compose(View $view){
        $active_users = (new User())->getActiveUsers();

        $view->with('active_users',$active_users);
    }
}