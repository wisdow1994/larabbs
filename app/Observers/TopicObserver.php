<?php

namespace App\Observers;

use App\Models\Topic;
use App\Handlers\SlugTranslateHandler;
use App\Jobs\TranslateSlug;//引入队列

// creating, created, updating, updated, saving,
// saved,  deleting, deleted, restoring, restored

class TopicObserver
{

    public function saving(Topic $topic)
    {
        //PHP的叫法->模型观察员,  文件是自动创建的,类似于python中orm的模型信号或者是叫做
        //XSS注入攻击,clean方法来自于purifier扩展,清洗用户提交数据中的html标签和属性
        //但是Simditor编辑器会自动转义提交内容中的语言,只有html原生的input会被XSS注入攻击吧
        $topic->body = clean($topic->body, 'user_topic_body');

        // 生成话题摘录
        $topic->excerpt = make_excerpt($topic->body);

    }

    public function saved(Topic $topic)
    {
        // 如 slug 字段无内容，即使用翻译器对 title 进行翻译
        if ( ! $topic->slug) {

            // 模型信号saved时,推送任务到队列
            dispatch(new TranslateSlug($topic));
        }
    }

    public function deleted(Topic $topic)
    {
        //监听deleted信号,当话题被删除时,所关联的回复也要全部删除
        //需要注意的是，在模型监听器中，数据库操作需要避免再次 Elequent 事件和信号的死循环，所以这里我们使用了 DB 类进行操作
        \DB::table('replies')->where('topic_id', $topic->id)->delete();
    }
}