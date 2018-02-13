<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call(UsersTableSeeder::class);
        $this->call(TopicsTableSeeder::class);
        $this->call(ReplysTableSeeder::class);
        //回滚之前的数据,重新填充数据,需要注意数据填充的顺序
        //php artisan migrate:refresh --seed
        //当报错Seeder文件不存在时,composer dump-autoload，然后php artisan db:seed
    }
}