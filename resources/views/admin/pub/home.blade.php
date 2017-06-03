<?php
use App\Model\Admin\AdminSession;
use App\Model\Admin\AdminPermission;
$userHead = AdminSession::getAdminInfo('AdminInfo');
$permissionHead = new AdminPermission();
$menu = $permissionHead->getMenu();
$showTitle = $permissionHead->showTitle();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <title>@yield('title')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1, user-scalable=no">
    <meta name="description" content="">
    <meta name="author" content="357831976@qq.com">
    <link rel="stylesheet" type="text/css" href="{{URL::asset('static/admin/css/cloud-admin.css')}}" >
    <link rel="stylesheet" type="text/css"  href="{{URL::asset('static/admin/css/default.css')}}" id="skin-switcher" >
    <link href="{{URL::asset('static/admin/css/font-awesome.min.css')}}" rel="stylesheet">
    <link href="{{URL::asset('static/admin/css/jquery-accordion-menu.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{URL::asset('static/admin/css/bootstrap.min.css')}}" rel="stylesheet" />
    <link href="{{URL::asset('static/admin/css/paper-dashboard.css')}}" rel="stylesheet"/>
    <script src="{{URL::asset('static/admin/js/jquery-1.11.2.min.js')}}" type="text/javascript"></script>
    <script src="{{URL::asset('static/admin/js/jquery-accordion-menu.js')}}" type="text/javascript"></script>
    @yield('href')
</head>
<body>
<header class="navbar clearfix" id="header">
    <div class="container">
        <div class="navbar-brand">
            <a href="{{url('admin')}}">
                <img src="{{URL::asset('static/admin/img/logo.png')}}" alt="Cloud Admin Logo" class="img-responsive" height="30" width="120">
            </a>
        </div>
        @if ($userHead)
        <ul class="nav navbar-nav pull-right">
            <li class="dropdown" id="header-notification">
						<span class="dropdown-toggle">
							<span class="badge-down">上次登录IP：{{$userHead['lastLoginIp']}}</span>
							<span class="badge-down">上次登录时间：{{date('Y-m-d H:i:s', $userHead['lastLoginTime'])}}</span>
						</span>
            </li>
            <li class="dropdown user" id="header-user">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                    <img alt="" src="{{URL::asset('static/admin/img/user.jpg')}}">
                    <span class="username">{{$userHead['userName']}}</span>
                    <i class="fa fa-angle-down username"></i>
                </a>
                <ul class="dropdown-menu">
                    <li><a href="{{url('admin/resetPassword')}}"><i class="fa fa-user"></i> 修改密码 </a></li>
                    <li><a href="{{url('admin/loginOut')}}"><i class="fa fa-cog"></i> 退出登录 </a></li>
                </ul>
            </li>
        </ul>
        @endif
    </div>
</header>
<section id="page">
    <div id="sidebar" class="sidebar">
        <div class="sidebar-menu nav-collapse">
            <div class="content">
                <div id="jquery-accordion-menu" class="jquery-accordion-menu red">
                    <ul id="demo-list">
                        @foreach($menu['data'] as $title => $list)
                            <li>
                                <a href="#"><i class="fa fa-bars"></i>{{$title}} </a>
                                <ul class="submenu" @if($title == $showTitle)style="display: block;"@endif>
                                    @foreach($list as $value)
                                        <li><a href="{{url($value['url'])}}">{{$value['name']}}</a></li>
                                    @endforeach
                                </ul>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="main-panel">
    @yield('content')
    </div>
</section>
<script type="text/javascript">
    jQuery("#jquery-accordion-menu").jqueryAccordionMenu();
    $("#header-user").click(function(){
        if ($(this).hasClass("open")) {
            $(this).removeClass("open");
        } else {
            $(this).addClass("open");
        }
    });
</script>
</body>
</html>