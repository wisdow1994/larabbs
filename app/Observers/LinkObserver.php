<?php

namespace App\Observers;

use App\Models\Link;
use Cache;

class LinkObserver
{
    //我们需要对模型进行监控，当发生模型修改时，清空对应 $cache_key 的缓存数据，接下来新建模型监控器
    //这条新修改或创建的模型会被单独sql查询出来
    // 在保持时清空 cache_key 对应的缓存
    public function saved(Link $link)
    {
        Cache::forget($link->cache_key);
    }
}