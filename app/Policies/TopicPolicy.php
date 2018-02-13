<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Topic;

class TopicPolicy extends Policy
{
    public function update(User $user, Topic $topic)
    {
//         return $topic->user_id == $user->id;
        return $user->isAuthorOf($topic);
         //只允许用户编辑自己的topic，在授权策略的类方法里，返回 true 即允许访问，反之返回 false 为拒绝访问。
    }

    public function destroy(User $user, Topic $topic)
    {
//        return $topic->user_id == $user->id;
        return $user->isAuthorOf($topic);
        //在User模型中定义了一个isAuthorOf方法
        //只允许用户删除属于自己的帖子
    }
}
