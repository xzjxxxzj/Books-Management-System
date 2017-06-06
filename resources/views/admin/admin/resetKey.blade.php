@extends('admin/pub/home')
@section('title')
    长耳兔 | 后台管理 | 修改密码
@stop
@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-8 col-md-7">
                    <div class="card">
                        <div class="header text-center">
                            <h4 class="title">修改密码</h4>
                        </div>
                        <div class="content">
                            <form action="{{url('admin/resetUserKey')}}" method="post">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>用户名：</label>
                                            <input type="text" class="form-control border-input" disabled value="{{$userInfo['userName']}}">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>新密码：</label>{{$errors->first('passWord')}}
                                            <input type="password" class="form-control border-input" name="passWord" placeholder="请输入新密码：6-20位字符" value="">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>确认新密码：</label>{{$errors->first('rePassword')}}
                                            <input type="password" class="form-control border-input" name="rePassword" placeholder="请再输入一次新密码" value="">
                                        </div>
                                    </div>
                                </div>
                                <div class="text-center">
                                    <input type="hidden" name="userId" value="{{$userInfo['id']}}"/>
                                    <input type="hidden" name="_token" value="{{csrf_token()}}"/>
                                    <button type="submit" class="btn btn-info btn-fill btn-wd">确认修改</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
