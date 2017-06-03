@extends('admin/pub/home')
@section('title')
    长耳兔 | 后台管理 | 添加用户
@stop
@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12 col-md-7">
                    <div class="card">
                        <div class="header">
                            <h4 class="title">添加用户</h4>
                        </div>
                        <div class="content">
                            <form action="{{url('admin/setAddUser')}}" method="post">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>用户名：</label>{{$errors->first('userName')}}
                                            <input type="text" class="form-control border-input" name="userName" placeholder="请输入用户名：6-16位，数字、字母组成" value="">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>姓名：</label>{{$errors->first('realName')}}
                                            <input type="text" class="form-control border-input" name="realName" placeholder="请输入用户姓名" value="">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>密码：</label>{{$errors->first('password')}}
                                            <input type="password" class="form-control border-input" name="password" placeholder="请输入密码：6-20位字符" value="">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>用户组：</label>{{$errors->first('group')}}
                                            <select class="form-control border-input" name="group">
                                                @if(!empty($group))
                                                    @foreach($group as $key => $value)
                                                        <option value="{{$value}}">{{$key}}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>所属店铺：</label>{{$errors->first('shop')}}
                                            <select class="form-control border-input" name="shop">
                                                @if(!empty($shop))
                                                    @foreach($shop as $key => $value)
                                                        <option value="{{$value}}">{{$key}}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>设置为组长：</label>{{$errors->first('groupLeader')}}
                                            <input type="checkbox" name="groupLeader" class="form-check" value="1">
                                        </div>
                                    </div>
                                </div>
                                <div>
                                    <input type="hidden" name="_token" value="{{csrf_token()}}"/>
                                    <button type="submit" class="btn btn-info btn-fill btn-wd">确认添加</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
