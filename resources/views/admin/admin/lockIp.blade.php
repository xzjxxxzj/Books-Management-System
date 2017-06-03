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
                            <h4 class="title">锁定IP</h4>
                        </div>
                        <div class="content">
                            <form action="{{url('admin/lockUser')}}" method="post">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>用户名：</label>
                                            <input type="text" class="form-control border-input" disabled value="{{$userInfo['username']}}">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>已锁定IP：（最多可锁定10个IP地址）</label><br />
                                                @if(!empty($userInfo['limitip']))
                                                    @foreach($userInfo['limitip'] as $value)
                                                    {{$value}}<br />
                                                    @endforeach
                                                @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label>操作：</label>{{$errors->first('type')}}
                                            <select class="form-control border-input" name="type">
                                                <option value="1">添加IP</option>
                                                <option value="2">删除IP</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>IP地址：</label>{{$errors->first('ipAdd')}}
                                            <input type="text" class="form-control border-input" name="ipAdd" value="">
                                        </div>
                                    </div>
                                </div>
                                <div>
                                    <input type="hidden" name="userId" value="{{$userInfo['id']}}"/>
                                    <input type="hidden" name="_token" value="{{csrf_token()}}"/>
                                    <button type="submit" class="btn btn-info btn-fill btn-wd">确认</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
