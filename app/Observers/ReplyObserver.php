<?php

namespace App\Observers;

use App\Models\Reply;

// creating, created, updating, updated, saving,
// saved,  deleting, deleted, restoring, restored

class ReplyObserver
{
    public function created(Reply $reply)
    {
        $reply->topic->increment('reply_count', 1);
        //reply模型创建成功后,属于的topic->reply_count增加1
    }

    public function creating(Reply $reply)
    {
        $reply->content = clean($reply->content, 'user_topic_body');

        //防止XSS注入攻击，清洗提交的数据,如果有js代码,效果会体现给用户自己,但不会保存在后台的数据库中
    }
}