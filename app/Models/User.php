<?php

namespace App\Models;//把model文件从Http\Controller文件夹移动到Models,命名空间也需要修改

use Auth;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    //自定义的方法,用来获取和设置最后登录时间
    use Traits\LastActivedAtHelper;
    //使用自定义的活跃算法,用来获取活跃用户
    use Traits\ActiveUserHelper;
    //使用 laravel-permission 提供的 Trait —— HasRoles此举能让我们获取到扩展包提供的所有权限和角色的操作方法
    use HasRoles;

    use Notifiable {
        notify as protected laravelNotify;
    }
    public function notify($instance)
    {
        /*
         * 虽然 notify() 已经很方便，但是我们还需要对其进行定制，
         * 我们希望每一次在调用 $user->notify() 时，自动将 users 表里的 notification_count +1 ，
         * 这样我们就能跟踪用户未读通知了
         * 如果要通知的人是当前用户，就不必通知了！
         */
        if ($this->id == Auth::id()) {
            return;
        }
        $this->increment('notification_count');
        $this->laravelNotify($instance);
    }

    public function markAsRead()
    {
        //用户访问消息列表后,会清空所有消息
        $this->notification_count = 0;
        $this->save();
        $this->unreadNotifications->markAsRead();
        //对消息通知数据库的未读通知(unreadNotifications)进行自定义操作
    }

    protected $fillable = [
        'name', 'email', 'password', 'introduction', 'avatar'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    public function topics()
    {
        return $this->hasMany(Topic::class);//用户之于话题,一对多
    }

    public function replies()
    {
        return $this->hasMany(Reply::class);//一个用户有多条回复
    }

    public function isAuthorOf($model)
    {
        return $this->id == $model->user_id;
    }

    public function setPasswordAttribute($value)
    {
        //使用修改器对password进行设置,对密码进行hash处理
        // 如果值的长度等于 60，即认为是已经做过加密的情况
        if (strlen($value) != 60) {

            // 不等于 60，做密码加密处理
            $value = bcrypt($value);
        }

        $this->attributes['password'] = $value;
    }

    public function setAvatarAttribute($path)
    {
        // 如果不是 `http` 子串开头，那就是从后台上传的，需要补全 URL
        if ( ! starts_with($path, 'http')) {

            // 拼接完整的 URL
            $path = config('app.url') . "/uploads/images/avatars/$path";
        }

        $this->attributes['avatar'] = $path;
    }
}
