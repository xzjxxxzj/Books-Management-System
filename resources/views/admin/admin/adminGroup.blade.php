@extends('admin/pub/home')
@section('title')
    长耳兔 | 后台管理 | 后台用户组列表
@stop
@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="header">
                            <h4 class="title">
                                <span>用户组管理</span>
                                <a href="{{url('admin/addUserGroup')}}" class="setright" title="添加用户组">
                                    <i class="fa fa-plus"></i>
                                </a>
                            </h4>
                        </div>
                        <div class="content table-responsive table-full-width">
                            <table class="table table-striped">
                                <thead>
                                <th>用户组名称</th>
                                <th>用户组状态</th>
                                <th>创建时间</th>
                                <th style="text-align: center">管理</th>
                                </thead>
                                <tbody>
                                @foreach($groupList as $value)
                                    <tr>
                                        <td>{{$value->groupName}}</td>
                                        <td>{{$value->status == 1 ? '禁用' : '正常'}}</td>
                                        <td>{{date('Y-m-d H:i:s', $value->createTime)}}</td>
                                        <td style="text-align: center">
                                            <a href="{{url('admin/setUserGroup/' . $value->groupId)}}" title="用户组编辑" style="margin-left: 3px;"><i class="fa fa-cog"></i></a>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            {!! $groupList->render() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop