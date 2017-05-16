<!DOCTYPE html>
<html lang="cn">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>提示页-长耳兔</title>
    <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon" />
    <link href="{{URL::asset('static/admin/css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{URL::asset('static/admin/css/style.min.css')}}" rel="stylesheet">
    <link href="{{URL::asset('static/pub/css/common.css')}}" rel="stylesheet">
</head>
</head>
<body>
<div class="container-fluid content">
    <div class="row">
        <div id="content" class="col-sm-12 full">
            <div class="row box-error">
                <div class="col-lg-12 col-md-12 col-xs-12">
                    <div class="text-center">
                        @if ($type)
                        <i class="iconbig-success"></i>
                        @else
                        <i class="iconbig-warn"></i>
                        @endif
                        <h2>{{$title}}</h2>
                        <p>{{$miaoshu}}</p>
                        @if (!empty($msg1))
                            <a href="{{current($msg1)}}">
                                <button class="btn btn-default"><span class="fa fa-chevron-left">{{key($msg1)}}</span></button>
                            </a>
                        @endif
                        @if (!empty($msg2))
                        <a href="{{current($msg2)}}">
                            <button class="btn btn-default"><span class="fa fa-envelope">{{key($msg2)}}</span></button>
                        </a>
                        @endif
                    </div>
                </div><!--/col-->
            </div><!--/row-->
        </div><!--/content-->
    </div><!--/row-->
</div><!--/container-->
</body>
</html>