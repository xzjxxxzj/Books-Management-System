@extends('admin/pub/home')
@section('title')
    长耳兔 | 后台管理 | 添加用户组
@stop
@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12 col-md-7">
                    <div class="card">
                        <div class="header">
                            <h4 class="title">添加用户组</h4>
                        </div>
                        <div class="content">
                            <form action="{{url('admin/setAddUserGroup')}}" method="post">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>组名称：</label>{{$errors->first('groupName')}}
                                            <input type="text" class="form-control border-input" name="groupName" placeholder="请输入组名称" value="">
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
