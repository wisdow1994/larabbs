@extends('layouts.app')

@section('title')
    我的通知
@endsection

@section('content')
    <div class="container">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">

                <div class="panel-body">

                    <h3 class="text-center">
                        <span class="glyphicon glyphicon-bell" aria-hidden="true"></span> 我的通知
                    </h3>
                    <hr>

                    @if ($notifications->count())

                        <div class="notification-list">
                            @foreach ($notifications as $notification)
                                @include('notifications.types._' . snake_case(class_basename($notification->type)))
                                {{--snake_case(class_basename($notification->type)) 渲染以后会是topic_replied。
                                class_basename()方法会取到 TopicReplied，
                                Laravel 的辅助方法 snake_case() 会字符串格式化为小写下划线命名。--}}
                            @endforeach

                            {!! $notifications->render() !!}
                        </div>

                    @else
                        <div class="empty-block">没有消息通知！</div>
                    @endif

                </div>
            </div>
        </div>
    </div>
@endsection