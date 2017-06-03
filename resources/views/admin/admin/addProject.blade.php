@extends('admin.pub.home')
@section('title')
    长耳兔 | 后台管理 | 添加项目
@stop
@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12 col-md-7">
                    <div class="card">
                        <div class="header">
                            <h4 class="title">添加项目</h4>
                        </div>
                        <div class="content">
                            <form action="{{url('admin/setAddProject')}}" method="post">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>项目名称：</label>{{$errors->first('name')}}
                                            <input type="text" class="form-control border-input" name="name" placeholder="请输入项目名称" value="{{old('name')}}">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>项目地址：</label>{{$errors->first('url')}}
                                            <input type="text" class="form-control border-input" name="url" placeholder="请输入项目地址" value="{{old('url')}}">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>是否菜单：</label>{{$errors->first('show')}}
                                            <select class="form-control border-input" name="show">
                                                <option value="1" {{old('show') == '1' ? 'selected' : ''}}>是</option>
                                                <option value="0" {{old('show') == '0' ? 'selected' : ''}}>否</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>父级菜单：</label>{{$errors->first('parentId')}}
                                            <select class="form-control border-input" name="parentId">
                                                <option value="0">目录</option>
                                                @if(!empty($menu))
                                                    @foreach($menu as $key => $value)
                                                        <option value="{{$key}}">{{$value}}</option>
                                                    @endforeach
                                                @endif
                                            </select>
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
