<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAvatarAndIntroductionToUsersTable extends Migration
{
    /**
     * Run the migrations.
     * 遵照如 add_column_to_table 这样的命名规范，并在生成迁移文件的命令中设置 --table 选项，用于指定对应的数据库表
     *php artisan make:migration add_avatar_and_introduction_to_users_table --table=users
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('avatar')->nullable();//存储用户的头像文件的路径,可以为空
            $table->string('introduction')->nullable();//用户的个人简介,可以为空
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('avatar');
            $table->dropColumn('introduction');
        });
    }
}
