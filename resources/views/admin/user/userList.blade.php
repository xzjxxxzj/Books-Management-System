@extends('admin/pub/home')
@section('title')
    长耳兔 | 后台管理 | 用户列表
@stop
@section('href')
    <script src="{{URL::asset('static/admin/js/dialog.js')}}" type="text/javascript"></script>
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
                                        <td>{{$value->jiFen}}</td>
                                        <td>{{date('Y-m-d H:i:s', $value->createTime)}}</td>
                                        <td style="text-align: center">
                                            <a href="{{url('admin/user/setUserInfo/' . $value->userId)}}" title="资料编辑" style="margin-left: 3px;"><i class="fa fa-cog"></i></a>
                                            <a href="javascript:showDialog({{$value->userId}});" title="借书" style="margin-left: 3px;"><i class="fa fa-arrow-left"></i></a>
                                            <a href="{{url('admin/user/borrowList?type=userName&name=' . $value->userName)}}" title="还书" style="margin-left: 3px;"><i class="fa fa-arrow-right"></i></a>
                                            <a href="{{url('admin/user/finance/' . $value->userId)}}" title="财务操作" style="margin-left: 3px;"><i class="fa fa-money"></i></a>
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
    <div class="ui-mask" id="mask" onselectstart="return false"></div>

    <div class="ui-dialog" id="dialogMove" onselectstart='return false;'>
        <div class="ui-dialog-title" id="dialogDrag"  onselectstart="return false;" >
            图书借阅
            <a class="ui-dialog-closebutton" href="javascript:hideDialog();"></a>
        </div>
        <form action="{{url('admin/user/borrowBook')}}" method="post">
        <div class="ui-dialog-content">
            <div class="row">
                <div class="col-md-9">
                    <div class="form-group">
                        <span>图书编号：</span>
                        <input type="text" class="form-dialog border-input" name="bookId" placeholder="请输入图书编号" value="">
                    </div>
                </div>
                <div class="col-md-9">
                    <div class="form-group">
                        <span>借阅数量：</span>
                        <input type="number" class="form-dialog border-input" name="num" placeholder="请输入数量" value="" min="1">
                    </div>
                </div>
            </div>
            <div>
                <input type="hidden" name="userId" value="" id="userId"/>
                <input type="hidden" name="_token" value="{{csrf_token()}}"/>
                <input type="submit" class="ui-dialog-submit" value="确 定" />
            </div>
        </div>
        </form>
    </div>
    <script>
        //	重新调整对话框的位置和遮罩，并且展现
        function showDialog(userId){
            $("#userId").val(userId);
            g('dialogMove').style.display = 'block';
            g('mask').style.display = 'block';
            autoCenter( g('dialogMove') );
            fillToBody( g('mask') );
        }

        //	关闭对话框
        function hideDialog(){
            g('dialogMove').style.display = 'none';
            g('mask').style.display = 'none';
        }

        Dialog('dialogDrag','dialogMove');
    </script>
@stop