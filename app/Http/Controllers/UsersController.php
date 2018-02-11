<?php


namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use Illuminate\Http\Request;
use App\Models\User;

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

    public function update(UserRequest $request, User $user)
    {
        $user->update($request->all());
        return redirect()->route('users.show', $user->id)->with('success', '个人资料更新成功');
    }
}
