@extends('admin/pub/home')
@section('title')
    长耳兔 | 后台管理 | 修改用户组
@stop
@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12 col-md-7">
                    <div class="card">
                        <div class="header">
                            <h4 class="title">修改用户组</h4>
                        </div>
                        <div class="content">
                            <form action="{{url('admin/updateGroup')}}" method="post">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>组名称：</label>{{$errors->first('groupName')}}
                                            <input type="text" class="form-control border-input" name="groupName" placeholder="请输入组名称" value="{{old('groupName') ? old('groupName') : $groupInfo['groupName']}}">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>状态：</label>{{$errors->first('status')}}
                                            <select class="form-control border-input" name="status">
                                                <option value="0" {{$groupInfo['status'] == 0 ? 'selected' : ''}}>启用</option>
                                                <option value="1" {{$groupInfo['status'] == 1 ? 'selected' : ''}}>禁用</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div>
                                    <input type="hidden" name="groupId" value="{{$groupInfo['groupId']}}"/>
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
