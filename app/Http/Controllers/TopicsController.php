<?php

namespace App\Http\Controllers;

use Auth;
use App\Models\Topic;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\TopicRequest;

class TopicsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['index', 'show']]);
    }

    public function index(Request $request, Topic $topic)
	{
//		$topics = Topic::paginate(30);//会有一个N+1问题存在,sql查询次数为30*2+1次查询,时间为11.6s
//        $topics = Topic::with('user', 'category')->paginate(30);
        //可以通过 Eloquent 提供的 预加载功能 来解决此问题，sql查询次数为5次,时间为2.6s

        $topics = $topic->withOrder($request->order)->paginate(20);
        //withOrder方法已经封装了with方法用于预加载
        //$request->order 是获取 URI http://larabbs.test/topics?order=recent 中的 order 参数
        return view('topics.index', compact('topics'));
	}

    public function show(Topic $topic)
    {

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

        return redirect()->route('topics.show', $topic->id)->with('message', 'Created successfully.');
    }

	public function edit(Topic $topic)
	{
        $this->authorize('update', $topic);
		return view('topics.create_and_edit', compact('topic'));
	}

	public function update(TopicRequest $request, Topic $topic)
	{
		$this->authorize('update', $topic);
		$topic->update($request->all());

		return redirect()->route('topics.show', $topic->id)->with('message', 'Updated successfully.');
	}

	public function destroy(Topic $topic)
	{
		$this->authorize('destroy', $topic);
		$topic->delete();

		return redirect()->route('topics.index')->with('message', 'Deleted successfully.');
	}
}