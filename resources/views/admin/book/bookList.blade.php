@extends('admin/pub/home')
@section('title')
    长耳兔 | 后台管理 | 图书列表
@stop
@section('content')
    <form action="{{url('admin/book/bookList')}}">
    <nav class="navbar navbar-default">
        <div class="container-fluid">
            <div class="navbar-header select-container">
                <span>类型：</span>
                <select class="select-control" name="type" id="type">
                    <option value="">选择搜索类型</option>
                    @if(!empty($getType))
                        @foreach($getType as $key => $value)
                            <option value="{{$key}}">{{$value}}</option>
                        @endforeach
                    @endif
                </select>
                <select class="select-control" name="typeValue" style="display: none;" id="typeValue">

                </select>
                <input type="text" name="name" class="select-control" value="" id="nameValue" style="display: none;">
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
                                <a href="{{url('admin/book/addBook')}}" class="setright" title="添加图书">
                                    <i class="fa fa-plus"></i>
                                </a>
                            </h4>
                        </div>
                        <div class="content table-responsive table-full-width">
                            <table class="table table-striped">
                                <thead>
                                <th>类别</th>
                                <th>图书名</th>
                                <th>店铺名称</th>
                                <th>借出总数</th>
                                <th>剩余库存</th>
                                <th>图书价格</th>
                                <th>是否上架</th>
                                <th style="text-align: center">管理</th>
                                </thead>
                                <tbody>
                                @foreach($bookList as $value)
                                    <tr>
                                        <td>{{$bookType["{$value->typeId}"]}}</td>
                                        <td>{{$value->bookName}}</td>
                                        <td>{{$shopType["{$value->shopId}"]}}</td>
                                        <td>{{$value->outNum}}</td>
                                        <td>{{$value->leftNum}}</td>
                                        <td>{{$value->money}}</td>
                                        <td>{{$value->status == 1 ? '上架' : '下架'}}</td>
                                        <td style="text-align: center">
                                            <a href="{{url('admin/book/setBookInfo/' . $value->bookId)}}" title="图书编辑" style="margin-left: 3px;"><i class="fa fa-cog"></i></a>
                                            <a href="{{url('admin/book/borrowBook/' . $value->bookId)}}" title="借出" style="margin-left: 3px;"><i class="fa fa-arrow-left"></i></a>
                                            <a href="{{url('admin/book/returnBook/' . $value->bookId)}}" title="归还" style="margin-left: 3px;"><i class="fa fa-arrow-right"></i></a>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            {!! $bookList->appends($_GET)->render() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        $("#type").change(function () {
            $("#typeValue").html('').hide();
            $("#nameValue").html('').hide();

            bookType = {!! json_encode($bookType) !!};
            shopType = {!! json_encode($shopType) !!};
            type = $("#type").val();
            if (type == 'typeId') {
                valueData = bookType;
            } else if (type == 'shopId') {
                valueData = shopType;
            } else if (type == 'bookName') {
                $("#typeValue").html('').hide();
                $("#nameValue").html('').show();
                return true;
            } else {
                $("#typeValue").html('').hide();
                return false;
            }
            html = '';
            for (var key in valueData) {
                html += '<option value="' + key + '">' + valueData[key] +'</option>';
            }
            if (html == '') {
                $("#typeValue").html('').hide();
                return false;
            }
            $("#typeValue").html(html).show();
        });
    </script>
@stop