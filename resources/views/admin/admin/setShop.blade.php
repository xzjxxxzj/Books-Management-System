@extends('admin/pub/home')
@section('title')
    长耳兔 | 后台管理 | 修改商店
@stop
@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12 col-md-7">
                    <div class="card">
                        <div class="header">
                            <h4 class="title">修改商店</h4>
                        </div>
                        <div class="content">
                            <form action="{{url('admin/updateShop')}}" method="post">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>商店名称：</label>{{$errors->first('shopName')}}
                                            <input type="text" class="form-control border-input" name="shopName" placeholder="请输入商店名称" value="{{old('shopName') ? old('shopName') : $shopInfo['shopname']}}">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>状态：</label>{{$errors->first('status')}}
                                            <select class="form-control border-input" name="status">
                                                <option value="0" {{$shopInfo['status'] == 0 ? 'selected' : ''}}>启用</option>
                                                <option value="1" {{$shopInfo['status'] == 1 ? 'selected' : ''}}>禁用</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div>
                                    <input type="hidden" name="shopId" value="{{$shopInfo['shopid']}}"/>
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
