@extends('admin/pub/home')
@section('title')
    长耳兔 | 后台管理 | 添加图书类别
@stop
@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-4 col-md-5">
                    <div class="card card-user">
                        <div class="image">

                        </div>
                        <div class="content">
                            <div class="author">
                                <div class="row fileupload-buttonbar">
                                    <div class="col-lg-12">
                                        <span class="btn btn-success fileinput-button">
                                            <i class="fa fa-plus"></i>
                                            <span>图书封面</span>
                                            <input type="file" name="files[]" multiple>
                                        </span>
                                        <button type="submit" class="btn btn-primary start">
                                            <i class="fa fa-arrow-circle-o-up"></i>
                                            <span>上传</span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="text-center" style="display: none">
                            <div class="row">
                                <div class="col-md-3 col-md-offset-1">
                                    <h5>12<br /><small>Files</small></h5>
                                </div>
                                <div class="col-md-4">
                                    <h5>2GB<br /><small>Used</small></h5>
                                </div>
                                <div class="col-md-3">
                                    <h5>24,6$<br /><small>Spent</small></h5>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card" style="display: none">
                        <div class="header">
                            <h4 class="title">最近谁借了<small style="float:right;"><a href="" ><i class="fa fa-plus">查看更多</i></a></small></h4>
                        </div>
                        <div class="content">
                            <ul class="list-unstyled team-members">
                                <li>
                                    <div class="row">
                                        <div class="col-xs-3">
                                            <div class="avatar">许振杰</div>
                                        </div>
                                        <div class="col-xs-6">
                                            海沧绿苑新城店<br />
                                            <span class="text-muted"><small>2017-05-31</small></span>
                                        </div>

                                        <div class="col-xs-3 text-right">
                                            90天
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="row">
                                        <div class="col-xs-3">
                                            <div class="avatar">许振杰</div>
                                        </div>
                                        <div class="col-xs-6">
                                            海沧绿苑新城店<br />
                                            <span class="text-muted"><small>2017-05-31</small></span>
                                        </div>

                                        <div class="col-xs-3 text-right">
                                            90天
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="row">
                                        <div class="col-xs-3">
                                            <div class="avatar">许振杰</div>
                                        </div>
                                        <div class="col-xs-6">
                                            海沧绿苑新城店<br />
                                            <span class="text-muted"><small>2017-05-31</small></span>
                                        </div>

                                        <div class="col-xs-3 text-right">
                                            90天
                                        </div>
                                    </div>
                                </li>
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
                            <form>
                                <div class="row">
                                    <div class="col-md-5">
                                        <div class="form-group">
                                            <label>图书名称</label>
                                            <input type="text" name="bookName" class="form-control border-input" placeholder="请输入图书名字" value="">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>库存</label>
                                            <input type="text" class="form-control border-input" placeholder="Username" value="michael23">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">价格</label>
                                            <input type="email" class="form-control border-input" placeholder="Email">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>录入店铺</label>
                                            <input type="text" class="form-control border-input" placeholder="Company" value="Chet">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>图书分类</label>
                                            <input type="text" class="form-control border-input" placeholder="Last Name" value="Faker">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>推荐最小年龄</label>
                                            <input type="number" class="form-control border-input" placeholder="推荐最小年龄，0表示不限制" value="0"  min="0" max="100">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>推荐最大年龄</label>
                                            <input type="number" class="form-control border-input" placeholder="推荐最大年龄，0表示不限制" value="0"  min="0" max="100">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>图书简介</label>
                                            <textarea rows="5" class="form-control border-input" placeholder="请录入图书简介" value="Mike"></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="text-center">
                                    <button type="submit" class="btn btn-info btn-fill btn-wd">添加图书</button>
                                </div>
                                <div class="clearfix"></div>
                            </form>
                        </div>
                    </div>
                </div>


            </div>
        </div>
    </div>
@stop