<?php

namespace App\Observers;

use App\Models\Reply;
use App\Notifications\TopicReplied;

// creating, created, updating, updated, saving,
// saved,  deleting, deleted, restoring, restored

class ReplyObserver
{
    public function created(Reply $reply)
    {
        $topic = $reply->topic;
        $reply->topic->increment('reply_count', 1);
        //reply模型创建成功后,属于的topic->reply_count增加1

        // 监控回复的created信号,通知作者话题被人回复了
        $topic->user->notify(new TopicReplied($reply));
        //默认的 User 模型中使用了 trait —— Notifiable，
        //它包含着一个可以用来发通知的方法 notify() ，此方法接收一个通知实例做参数
        //但是在User模型中,重写了notify(),定制了更多的功能
    }

    public function creating(Reply $reply)
    {
        $reply->content = clean($reply->content, 'user_topic_body');

        //防止XSS注入攻击，清洗提交的数据,如果有js代码,效果会体现给用户自己,但不会保存在后台的数据库中
    }

    public function deleted(Reply $reply)
    {
        //相应的,回复被删除时,话题的reply_count也要减去1
        $reply->topic->decrement('reply_count', 1);
    }
}