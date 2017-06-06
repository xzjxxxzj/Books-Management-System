@extends('admin/pub/home')
@section('title')
    长耳兔 | 后台管理 | 登录日志
@stop
@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="header">
                            <h4 class="title">
                                <span>登录日志</span>
                            </h4>
                        </div>
                        <div class="content table-responsive table-full-width">
                            <table class="table table-striped">
                                <thead>
                                <th>用户名</th>
                                <th>登录状态</th>
                                <th>登录时间</th>
                                <th>登录IP</th>
                                </thead>
                                <tbody>
                                @foreach($list as $value)
                                    <tr>
                                        <td>{{$value->userName}}</td>
                                        <td>{{$value->status == 1 ? '成功' : '失败'}}</td>
                                        <td>{{date('Y-m-d H:i:s', $value->time)}}</td>
                                        <td>{{$value->loginIp}}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            {!! $list->render() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop