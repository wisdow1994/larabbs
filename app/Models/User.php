<?php

namespace App\Models;//把model文件从Http\Controller文件夹移动到Models,命名空间也需要修改

use Auth;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
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

}
