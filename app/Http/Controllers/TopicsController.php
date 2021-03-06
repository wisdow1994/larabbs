<?php

namespace App\Http\Controllers;

use Auth;
use App\Models\User;
use App\Models\Topic;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\TopicRequest;
use App\Handlers\ImageUploadHandler;//自定义的文件存储方法

class TopicsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['index', 'show']]);
    }

    public function index(Request $request, Topic $topic, User $user)
	{
//		$topics = Topic::paginate(30);//会有一个N+1问题存在,sql查询次数为30*2+1次查询,时间为11.6s
//        $topics = Topic::with('user', 'category')->paginate(30);
        //可以通过 Eloquent 提供的 预加载功能 来解决此问题，sql查询次数为5次,时间为2.6s

        $topics = $topic->withOrder($request->order)->paginate(20);
//        $active_users = $user->getActiveUsers();
        //已经注册了一个视图合成器,不用再多个控制器中传递active_users参数了
        //withOrder方法已经封装了with方法用于预加载
        //$request->order 是获取 URI http://larabbs.test/topics?order=recent 中的 order 参数
//        return view('topics.index', compact('topics', 'active_users'));
        return view('topics.index', compact('topics'));
	}

    public function show(Request $request, Topic $topic)
    {
        if ( ! empty($topic->slug) && $topic->slug != $request->slug) {
            return redirect($topic->link(), 301);
        }
        /*
         * 我们需要访问用户请求的路由参数 Slug，在 show() 方法中我们注入 $request；
            ! empty($topic->slug) 如果话题的 Slug 字段不为空；
            && $topic->slug != $request->slug 并且话题 Slug 不等于请求的路由参数 Slug；
        http://larabbs.test/topics/111 会跳转到http://larabbs.test/topics/111/best
         */

        return view('topics.show', compact('topic'));
    }

	public function create(Topic $topic)
	{
        $categories = Category::all();//创建话题时可以选择分类
        return view('topics.create_and_edit', compact('topic', 'categories'));
	}

    public function store(TopicRequest $request, Topic $topic)
    {
        /*
         * 代码解析：

    因为要使用到 Auth 类，所以需在文件顶部进行加载；
    store() 方法的第二个参数，会创建一个空白的 $topic 实例；
    $request->all() 获取所有用户的请求数据数组，如 ['title' => '标题', 'body' => '内容', ... ]；
    $topic->fill($request->all()); fill 方法会将传参的键值数组填充到模型的属性中，如以上数组，$topic->title 的值为 标题；
    Auth::id() 获取到的是当前登录的 ID；
    $topic->save() 保存到数据库中。

         */
        $topic->fill($request->all());
        $topic->user_id = Auth::id();
        $topic->save();

//        return redirect()->route('topics.show', $topic->id)->with('message', '成功创建话题.');
        return redirect()->to($topic->link())->with('success', '成功创建话题！');
    }

	public function edit(Topic $topic)
	{
        $this->authorize('update', $topic);//对update操作权限验证
        $categories = Category::all();
		return view('topics.create_and_edit', compact('topic', 'categories'));
	}

	public function update(TopicRequest $request, Topic $topic)
	{
		$this->authorize('update', $topic);
		$topic->update($request->all());

//		return redirect()->route('topics.show', $topic->id)->with('message', '修改成功.');
        return redirect()->to($topic->link())->with('success', '成功修改！');
	}

	public function destroy(Topic $topic)
	{
        $this->authorize('destroy', $topic);
        $topic->delete();

        return redirect()->route('topics.index')->with('success', '成功删除！');
	}

    public function uploadImage(Request $request, ImageUploadHandler $uploader)
    {
        // 初始化返回数据，默认是失败的
        $data = [
            'success'   => false,
            'msg'       => '上传失败!',
            'file_path' => ''
        ];
        // 判断是否有上传文件，并赋值给 $file
        if ($file = $request->upload_file) {
            // 保存图片到本地
            $result = $uploader->save($request->upload_file, 'topics', \Auth::id(), 1024);
            // 图片保存成功的话
            if ($result) {
                $data['file_path'] = $result['path'];
                $data['msg']       = "上传成功!";
                $data['success']   = true;
            }
        }
        return $data;
    }
}