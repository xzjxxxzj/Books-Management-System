<!DOCTYPE html>
<html lang="cn">
<head>
	<meta http-equiv="content-type" content="text/html; charset=UTF-8">
	<meta charset="utf-8">
	<title>@yield('title')</title>
	<link rel="shortcut icon" href="/favicon.ico" type="image/x-icon" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1, user-scalable=no">
	<meta name="description" content="">
	<meta name="author" content="357831976@qq.com">
	<link rel="stylesheet" type="text/css" href="{{URL::asset('static/admin/css/cloud-admin.css')}}" >
	<link href="{{URL::asset('static/admin/css/font-awesome.min.css')}}" rel="stylesheet">
	<script src="{{URL::asset('static/admin/js/jquery-2.0.3.min.js')}}"></script>
	@yield('head')
</head>
    @yield('body')
@yield('footer')
</html>