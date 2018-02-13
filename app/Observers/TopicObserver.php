<?php

namespace App\Observers;

use App\Models\Topic;
use App\Handlers\SlugTranslateHandler;

// creating, created, updating, updated, saving,
// saved,  deleting, deleted, restoring, restored

class TopicObserver
{
    public function creating(Topic $topic)
    {
        //
    }

    public function updating(Topic $topic)
    {
        //
    }

    public function saving(Topic $topic)
    {
        //文件是自动创建的,类似于python中orm的模型信号或者是叫做
        //XSS过滤,clean方法来自于purifier扩展,清洗用户提交数据中的html标签和属性
        $topic->body = clean($topic->body, 'user_topic_body');

        // 生成话题摘录
        $topic->excerpt = make_excerpt($topic->body);

        // 如 slug 字段无内容，即使用翻译器对 title 进行翻译
        if ( ! $topic->slug) {
            $topic->slug = app(SlugTranslateHandler::class)->translate($topic->title);
        }
    }
}