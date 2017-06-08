@extends('admin/pub/home')
@section('title')
    长耳兔 | 后台管理 | 借书列表
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
                                <span>借阅管理</span>
                            </h4>
                        </div>
                        <div class="content table-responsive table-full-width">
                            <table class="table table-striped">
                                <thead>
                                <th>图书ID</th>
                                <th>图书名称</th>
                                <th>用户名</th>
                                <th>借书时间</th>
                                <th>数量</th>
                                <th>归还数量</th>
                                <th>归还时间</th>
                                <th>总费用</th>
                                <th>折扣金额</th>
                                <th>状态</th>
                                <th style="text-align: center">管理</th>
                                </thead>
                                <tbody>
                                @foreach($borrowList as $value)
                                    <tr>
                                        <td>{{$value->bookId}}</td>
                                        <td>{{$value->bookName}}</td>
                                        <td>{{$value->userName}}</td>
                                        <td>{{date('Y-m-d', $value->borrowTime)}}</td>
                                        <td>{{$value->num}}</td>
                                        <td>{{$value->repayNum}}</td>
                                        <td>{{$value->repayTime ? date('Y-m-d H:i:s', $value->repayTime) : ''}}</td>
                                        <td>{{$value->money}}</td>
                                        <td>{{$value->discount}}</td>
                                        <td>{{$status["$value->status"]}}</td>
                                        <td style="text-align: center">
                                            <a href="{{url('admin/user/setOrder/' . $value->orderId)}}" title="订单编辑" style="margin-left: 3px;"><i class="fa fa-cog"></i></a>
                                            @if($value->status == '0')
                                            <a href="{{url('admin/user/setOrderStatus/' . $value->orderId)}}" title="借出" style="margin-left: 3px;" onclick="return confirm('是否借出书籍?')"><i class="fa fa-arrow-left"></i></a>
                                            @elseif($value->status == '1')
                                            <a href="javascript:showDialog('{{$value->bookName}}', '{{$value->num}}', '{{$value->orderId}}');" title="还书" style="margin-left: 3px;"><i class="fa fa-arrow-right"></i></a>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            {!! $borrowList->appends($_GET)->render() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="ui-mask" id="mask" onselectstart="return false"></div>

    <div class="ui-dialog" id="dialogMove" onselectstart='return false;'>
        <div class="ui-dialog-title" id="dialogDrag"  onselectstart="return false;" >
            归还书籍
            <a class="ui-dialog-closebutton" href="javascript:hideDialog();"></a>
        </div>
        <form action="{{url('admin/user/countMoney')}}" method="post" id="countMoney">
            <div class="ui-dialog-content">
                <div class="row">
                    <div class="col-md-9">
                        <div class="form-group">
                            <span>图书名称：</span>
                            <input type="text" class="form-dialog border-input" disabled value="" id="bookName">
                        </div>
                    </div>
                    <div class="col-md-9">
                        <div class="form-group">
                            <span>借阅数量：</span>
                            <input type="number" class="form-dialog border-input" disabled value="" id="num">
                        </div>
                    </div>
                    <div class="col-md-9">
                        <div class="form-group">
                            <span>归还数量：</span>
                            <input type="number" class="form-dialog border-input" value="" name="repayNum" id="repayNum" min="1">
                        </div>
                    </div>
                </div>
                <div>
                    <input type="hidden" name="orderId" value="" id="orderId"/>
                    <input type="hidden" name="_token" value="{{csrf_token()}}"/>
                    <input type="button" class="ui-dialog-submit" value="确 定" id="start"/>
                </div>
            </div>
        </form>
    </div>

    <div class="ui-dialog" id="repay" onselectstart='return false;'>
        <div class="ui-dialog-title" id="repayDrag"  onselectstart="return false;" >
            归还书籍
            <a class="ui-dialog-closebutton" href="javascript:hideDialog();"></a>
        </div>
        <form action="{{url('admin/user/repayBook')}}" method="post">
            <div class="ui-dialog-content">
                <div class="row">
                    <div class="col-md-9">
                        <div class="form-group">
                            <span>应收金额：</span>
                            <input type="text" class="form-dialog border-input" disabled value="" id="money">
                        </div>
                    </div>
                    <div class="col-md-9">
                        <div class="form-group">
                            <span>折扣金额：</span>
                            <input type="number" class="form-dialog border-input" disabled value="" id="rate">
                        </div>
                    </div>
                    <div class="col-md-9">
                        <div class="form-group">
                            <span>实收金额：</span>
                            <input type="number" class="form-dialog border-input" value="" name="realMoney" id="realMoney" min="0.1" step="0.1">
                        </div>
                    </div>
                </div>
                <div>
                    <input type="hidden" name="orderId" value="" id="payId"/>
                    <input type="hidden" name="_token" value="{{csrf_token()}}"/>
                    <input type="submit" class="ui-dialog-submit" value="确 定" />
                </div>
            </div>
        </form>
    </div>
    <script>
        //	重新调整对话框的位置和遮罩，并且展现
        function showDialog(bookName, num, orderId){
            $("#bookName").val(bookName);
            $("#num").val(num);
            $("#orderId, #payId").val(orderId);
            g('dialogMove').style.display = 'block';
            g('mask').style.display = 'block';
            autoCenter( g('dialogMove') );
            fillToBody( g('mask') );
        }

        $("#start").click(function() {
            var num = $("#num").val();
            var repayNum = $("#repayNum").val();
            if ( repayNum == '' || repayNum > num) {
                alert('请输入正确的归还数量！');
                return false;
            }
            $("#countMoney").ajaxForm({
                dataType:'json',
                success: function(data) {
                    if (data.code == '1') {
                        $("#money").val(100);
                        $("#rate").val(10);
                        g('repay').style.display = 'block';
                        g('mask').style.display = 'block';
                        autoCenter( g('repay') );
                        fillToBody( g('mask') );
                    } else {
                        alert(data.msg);
                    }
                }
            });
        });

        //	关闭对话框
        function hideDialog(){
            g('dialogMove').style.display = 'none';
            g('repay').style.display = 'none';
            g('mask').style.display = 'none';
        }

        Dialog('dialogDrag','dialogMove');
        Dialog('repayDrag','repay');
    </script>
@stop