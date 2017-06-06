@extends('admin/pub/home')
@section('title')
    长耳兔 | 后台管理 | 用户列表
@stop
@section('content')
    <form action="{{url('admin/user/userList')}}">
        <nav class="navbar navbar-default">
            <div class="container-fluid">
                <div class="navbar-header select-container">
                    <span>类型：</span>
                    <select class="select-control" name="type">
                        <option value="">选择搜索类型</option>
                        @if(!empty($getType))
                            @foreach($getType as $key => $value)
                                <option value="{{$key}}" @if(!empty($_GET['type']) && $_GET['type'] == $key) selected @endif>{{$value}}</option>
                            @endforeach
                        @endif
                    </select>
                    <input type="text" name="name" class="select-control" value="{{!empty($_GET['name']) ? $_GET['name'] : ''}}">
                    <button type="submit" class="btn btn-info btn-fill btn-wd">搜索</button>
                </div>
            </div>
        </nav>
    </form>
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="header">
                            <h4 class="title">
                                <span>图书管理</span>
                            </h4>
                        </div>
                        <div class="content table-responsive table-full-width">
                            <table class="table table-striped">
                                <thead>
                                <th>用户ID</th>
                                <th>用户名</th>
                                <th>姓名</th>
                                <th>手机</th>
                                <th>用户组</th>
                                <th>积分</th>
                                <th>创建时间</th>
                                <th style="text-align: center">管理</th>
                                </thead>
                                <tbody>
                                @foreach($userList as $value)
                                    <tr>
                                        <td>{{$value->userId}}</td>
                                        <td>{{$value->userName}}</td>
                                        <td>{{$value->realName}}</td>
                                        <td>{{$value->mobile}}</td>
                                        <td>{{$value->group}}</td>
                                        <td>{{$value->jifen}}</td>
                                        <td>{{date('Y-m-d H:i:s', $value->createTime)}}</td>
                                        <td style="text-align: center">
                                            <a href="{{url('admin/user/setUserInfo/' . $value->userId)}}" title="资料编辑" style="margin-left: 3px;"><i class="fa fa-cog"></i></a>
                                            <a href="{{url('admin/user/repayBook/' . $value->userId)}}" title="还书" style="margin-left: 3px;"><i class="fa fa-arrow-left"></i></a>
                                            <a href="{{url('admin/user/finance/' . $value->userId)}}" title="财务操作" style="margin-left: 3px;"><i class="fa fa-arrow-right"></i></a>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            {!! $userList->appends($_GET)->render() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop