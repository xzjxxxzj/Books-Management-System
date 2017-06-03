@extends('admin/pub/home')
@section('title')
    长耳兔 | 后台管理 | 图书类别列表
@stop
@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="header">
                            <h4 class="title">
                                <span>图书类别管理</span>
                                <a href="{{url('admin/book/addBookType')}}" class="setright" title="添加类别">
                                    <i class="fa fa-plus"></i>
                                </a>
                            </h4>
                        </div>
                        <div class="content table-responsive table-full-width">
                            <table class="table table-striped">
                                <thead>
                                <th>类别名称</th>
                                <th>类别状态</th>
                                <th>创建时间</th>
                                <th style="text-align: center">管理</th>
                                </thead>
                                <tbody>
                                @foreach($bookType as $value)
                                    <tr>
                                        <td>{{$value->typename}}</td>
                                        <td>{{$value->status == 1 ? '禁用' : '正常'}}</td>
                                        <td>{{date('Y-m-d H:i:s', $value->createtime)}}</td>
                                        <td style="text-align: center">
                                            <a href="{{url('admin/book/setBookType/' . $value->typeid)}}" title="类别编辑" style="margin-left: 3px;"><i class="fa fa-cog"></i></a>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            {!! $bookType->render() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop