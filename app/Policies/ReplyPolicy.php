<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Reply;

class ReplyPolicy extends Policy
{
    public function destroy(User $user, Reply $reply)
    {
        return $user->isAuthorOf($reply)  || $user->isAuthorOf($reply->topic);
        //只有reply的作者,或者reply所属topic的作者才有权限删除
    }
}
