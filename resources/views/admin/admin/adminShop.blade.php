@extends('admin/pub/home')
@section('title')
    长耳兔 | 后台管理 | 后台商店列表
@stop
@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="header">
                            <h4 class="title">
                                <span>商店管理</span>
                                <a href="{{url('admin/addShop')}}" class="setright" title="添加商店">
                                    <i class="fa fa-plus"></i>
                                </a>
                            </h4>
                        </div>
                        <div class="content table-responsive table-full-width">
                            <table class="table table-striped">
                                <thead>
                                <th>商店名称</th>
                                <th>商店状态</th>
                                <th>创建时间</th>
                                <th style="text-align: center">管理</th>
                                </thead>
                                <tbody>
                                @foreach($shopList as $value)
                                    <tr>
                                        <td>{{$value->shopname}}</td>
                                        <td>{{$value->status == 1 ? '禁用' : '正常'}}</td>
                                        <td>{{date('Y-m-d H:i:s', $value->createtime)}}</td>
                                        <td style="text-align: center">
                                            <a href="{{url('admin/setShop/' . $value->shopid)}}" title="商店编辑" style="margin-left: 3px;"><i class="fa fa-cog"></i></a>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            {!! $shopList->render() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop