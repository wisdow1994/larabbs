<?php

use Illuminate\Database\Seeder;
use App\Models\Reply;
use App\Models\User;
use App\Models\Topic;

class ReplysTableSeeder extends Seeder
{
    public function run()
    {
        // 所有用户 ID 数组，如：[1,2,3,4]
        $user_ids = User::all()->pluck('id')->toArray();

        // 所有话题 ID 数组，如：[1,2,3,4]
        $topic_ids = Topic::all()->pluck('id')->toArray();

        // 获取 Faker 实例
        $faker = app(Faker\Generator::class);
        /*
        * factory(User::class) 根据指定的 User 生成模型工厂构造器，对应加载 UserFactory.php 中的工厂设置。
       times(10) 指定生成模型的数量，此处我们只需要生成 10 个用户数据。
       make() 方法会将结果生成为 集合对象。
       each() 是 集合对象 提供的 方法，用来迭代集合中的内容并将其传递到回调函数中。
       use 是 PHP 中匿名函数提供的本地变量传递机制，匿名函数中必须通过 use 声明的引用，才能使用本地变量。
       makeVisible() 是 Eloquent 对象提供的方法，可以显示 User 模型 $hidden 属性里指定隐藏的字段，此操作确保入库时数据库不会报错。
        */
        $replys = factory(Reply::class)
            ->times(1000)
            ->make()
            ->each(function ($reply, $index)
            use ($user_ids, $topic_ids, $faker)
            {
                // 从用户 ID 数组中随机取出一个并赋值
                $reply->user_id = $faker->randomElement($user_ids);

                // 话题 ID，同上
                $reply->topic_id = $faker->randomElement($topic_ids);
            });

        // 将数据集合转换为数组，并插入到数据库中
        Reply::insert($replys->toArray());
    }
}