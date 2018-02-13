<?php

namespace App\Models;//把model文件从Http\Controller文件夹移动到Models,命名空间也需要修改

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'introduction', 'avatar'
    ];

    public function isAuthorOf($model)
    {
        return $this->id == $model->user_id;
    }

    protected $hidden = [
        'password', 'remember_token',
    ];

    public function topics()
    {
        return $this->hasMany(Topic::class);//用户之于话题,一对多
    }
}
