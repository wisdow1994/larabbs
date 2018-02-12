<?php


namespace App\Http\Controllers;


use Illuminate\Http\Request;

use App\Http\Requests\UserRequest;
use App\Models\User;
use App\Handlers\ImageUploadHandler;//自定义的图片上传类

class UsersController extends Controller
{
    public function show(User $user)
    {
        //显示用户个人资料，此功能叫做『隐性路由模型绑定』,会自动匹配resource路由中的用户模型实例
        return view('pages.show', compact('user'));
    }

    public function edit(User $user)
    {
        return view('pages.edit', compact('user'));
    }

    public function update(ImageUploadHandler $uploader, UserRequest $request, User $user)
    {

        $data = $request->all();

        if ($request->avatar) {
            $result = $uploader->save($request->avatar, 'avatars', $user->id, 362);
            if ($result) {
                $data['avatar'] = $result['path'];
            }
        }

        $user->update($data);
        return redirect()->route('users.show', $user->id)->with('success', '个人资料更新成功');
    }
}
