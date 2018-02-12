<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		$this->call(TopicsTableSeeder::class);
		$this->call(UsersTableSeeder::class);//使用数据填充
        //php artisan migrate:refresh --seed,之前的数据回滚并填充假数据
    }
}
