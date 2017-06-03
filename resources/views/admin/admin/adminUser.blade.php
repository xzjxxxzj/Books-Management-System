@extends('admin/pub/home')
@section('title')
    长耳兔 | 后台管理 | 后台用户列表
@stop
@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="header">
                            <h4 class="title">
                                <span>用户管理</span>
                                <a href="{{url('admin/addUser')}}" class="setright" title="添加用户">
                                    <i class="fa fa-plus"></i>
                                </a>
                            </h4>
                        </div>
                        <div class="content table-responsive table-full-width">
                            <table class="table table-striped">
                                <thead>
                                <th>用户名</th>
                                <th>姓名</th>
                                <th>用户状态</th>
                                <th>创建时间</th>
                                <th style="text-align: center">管理</th>
                                </thead>
                                <tbody>
                                @foreach($userList as $value)
                                <tr>
                                    <td>{{$value->username}}</td>
                                    <td>{{$value->realname}}</td>
                                    <td>{{$value->status == 1 ? '禁用' : '正常'}}</td>
                                    <td>{{date('Y-m-d H:i:s', $value->createtime)}}</td>
                                    <td style="text-align: center">
                                        <a href="{{url('admin/setInfo/' . $value->id)}}" title="用户编辑" style="margin-left: 3px;"><i class="fa fa-cog"></i></a>
                                        <a href="{{url('admin/setPermission/' . $value->id)}}" title="权限管理" style="margin-left: 3px;"><i class="fa fa-edit"></i></a>
                                        <a href="{{url('admin/resetKey/' . $value->id)}}" title="修改密码" style="margin-left: 3px;"><i class="fa fa-key"></i></a>
                                        <a href="{{url('admin/lockIp/' . $value->id)}}" title="锁定IP" style="margin-left: 3px;"><i class="fa fa-lock red"></i></a>
                                        <a href="{{url('admin/enableUser/' . $value->id . '/1')}}" title="删除用户" style="margin-left: 3px;" onclick="return confirm('确定停用该用户吗?')"><i class="fa fa-minus red"></i></a>
                                        <a href="{{url('admin/enableUser/' . $value->id . '/0')}}" title="恢复删除" style="margin-left: 3px;" onclick="return confirm('确定恢复该用户吗?')"><i class="fa fa-unlock red"></i></a>
                                    </td>
                                </tr>
                                @endforeach
                                </tbody>
                            </table>
                            {!! $userList->render() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop