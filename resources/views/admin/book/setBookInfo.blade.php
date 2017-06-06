@extends('admin/pub/home')
@section('title')
    长耳兔 | 后台管理 | 添加图书类别
@stop
@section('href')
    <script src="{{URL::asset('static/admin/js/jquery.form.js')}}" type="text/javascript"></script>
@stop
@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-4 col-md-5">
                    <div class="card card-user">
                        <div class="image" id="fengmian">
                            @if($bookInfo['image'])
                            <img src="/{{$bookInfo['image']}}" />
                            @endif
                        </div>
                        <div class="content">
                            <div class="author">
                                <div class="row fileupload-buttonbar">
                                    <div class="col-lg-12">
                                        <form action="{{url('admin/book/addBookImage')}}" method="post" enctype="multipart/form-data" id="upFiles">
                                            <input type="hidden" name="_token" value="{{csrf_token()}}"/>
                                            <span class="btn btn-success fileinput-button">
                                                <i class="fa fa-plus"></i>
                                                <span>图书封面</span>
                                                <input type="file" name="files">
                                            </span>
                                            <button type="submit" class="btn btn-primary start">
                                                <i class="fa fa-arrow-circle-o-up"></i>
                                                <span>上传</span>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="text-center">
                            <div class="row">
                                <div class="col-md-3 col-md-offset-1">
                                    <h5>{{$bookInfo['num']}} / {{$bookInfo['leftNum']}}<br /><small>总数 / 库存</small></h5>
                                </div>
                                <div class="col-md-4">
                                    <h5>{{$bookInfo['num'] - $bookInfo['lose'] - $bookInfo['spoil'] - $bookInfo['leftNum']}} / {{$bookInfo['outNum']}}<br /><small>借出 / 借出次数</small></h5>
                                </div>
                                <div class="col-md-3">
                                    <h5>{{$bookInfo['spoil']}} / {{$bookInfo['lose']}}<br /><small>损坏 / 丢失</small></h5>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="header">
                            <h4 class="title">最近谁借了<small style="float:right;"><a href="{{url('admin/book/bookOrder?bookId=' . $bookInfo['bookId'])}}" ><i class="fa fa-plus">查看更多</i></a></small></h4>
                        </div>
                        <div class="content">
                            <ul class="list-unstyled team-members">
                            @if(!empty($bookOrder))
                            @foreach($bookOrder as $value)
                                <li>
                                    <div class="row">
                                        <div class="col-xs-3">
                                            <div class="avatar">{{$value['userName']}}</div>
                                        </div>
                                        <div class="col-xs-6">
                                            {{date('Y-m-d', $value['borrowTime'])}}
                                        </div>

                                        <div class="col-xs-3 text-right">
                                            @if($value['status'] == '0')
                                            {{timeDiff(date('Y-m-d', $value['borrowTime']), date('Y-m-d'), 'days天')}}
                                            @else
                                            {{timeDiff(date('Y-m-d', $value['borrowTime']), date('Y-m-d', $value['repayTime']), 'days天')}}
                                            @endif
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                            @endif
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-lg-8 col-md-7">
                    <div class="card">
                        <div class="header">
                            <h4 class="title">图书资料录入</h4>
                        </div>
                        <div class="content">
                            <form action="{{url('admin/book/updateBookInfo')}}" method="post">
                                <div class="row">
                                    <div class="col-md-5">
                                        <div class="form-group">
                                            <label>图书名称*</label>{{$errors->first('bookName')}}
                                            <input type="text" name="bookName" class="form-control border-input" placeholder="请输入图书名字" value="{{old('bookName') ? old('bookName') : $bookInfo['bookName']}}">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>库存±*</label>{{$errors->first('leftNum')}}
                                            <input type="number" name="leftNum" class="form-control border-input" placeholder="图书库存量增加" value="{{old('leftNum')}}" min="-{{$bookInfo['leftNum']}}">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>价格*</label>{{$errors->first('money')}}
                                            <input type="number" name="money" class="form-control border-input" placeholder="图书价格，如丢失按此价格赔偿" value="{{old('money') ? old('money') : $bookInfo['money']}}" min="0" step="0.1">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>店铺</label>{{$errors->first('shopId')}}
                                            <select class="form-control border-input" name="shopId">
                                                @if(!empty($shopType))
                                                    @foreach($shopType as $key => $value)
                                                        <option value="{{$key}}" {{$key == $bookInfo['shopId'] ? 'selected' : ''}}>{{$value}}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>分类</label>{{$errors->first('typeId')}}
                                            <select class="form-control border-input" name="typeId">
                                                @if(!empty($bookType))
                                                    @foreach($bookType as $key => $value)
                                                        <option value="{{$key}}" {{$key == $bookInfo['typeId'] ? 'selected' : ''}}>{{$value}}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>推荐最小年龄</label>{{$errors->first('minAge')}}
                                            <input type="number" name="minAge" class="form-control border-input" placeholder="推荐最小年龄，0表示不限制" value="{{old('minAge') ? old('minAge') : $bookInfo['minAge']}}" min="0" max="100">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>推荐最大年龄</label>{{$errors->first('maxAge')}}
                                            <input type="number" name="maxAge" class="form-control border-input" placeholder="推荐最大年龄，0表示不限制" value="{{old('maxAge') ? old('maxAge') : $bookInfo['maxAge']}}" min="0" max="100">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>图书简介  <small>您还可以输入<span id="word">200</span>个字符</small></label>{{$errors->first('profile')}}
                                            <textarea rows="5" name="profile" class="form-control border-input" placeholder="请录入图书简介" id="profile">{{old('profile') ? old('profile') : $bookInfo['profile']}}</textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="text-center">
                                    <input type="hidden" name="bookId" value="{{$bookInfo['bookId']}}"/>
                                    <input type="hidden" name="fileId" value="" id="fileId"/>
                                    <input type="hidden" name="imagePath" value="{{old('imagePath') ? old('imagePath') : $bookInfo['image']}}" id="imagePath"/>
                                    <input type="hidden" name="_token" value="{{csrf_token()}}"/>
                                    <button type="submit" class="btn btn-info btn-fill btn-wd">保存修改</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        profile();
        $(".start").click(function() {
            $("#upFiles").ajaxForm({
                dataType:'json',
                success: function(data) {
                    if (data.code == '1') {
                        $("#fileId").val(data.data.fileId);
                        html = '<img src="/' + data.data.files['0'].path+ '" />';
                        $("#fengmian").html(html);
                        $("#imagePath").val(data.data.files['0'].path);
                    } else {
                        alert(data.msg);
                    }
                }
            });
        });

        $("#profile").keyup(function () {
            profile();
        })

        function profile()
        {
            var len = $("#profile").val().length;
            if(len > 200){
                $("#profile").val($("#profile").val().substring(0,200));
            }
            var num = 200 - len;
            $("#word").text(num);
        }
    </script>
@stop