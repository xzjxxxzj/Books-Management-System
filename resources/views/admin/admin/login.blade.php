@extends('admin/pub/admin')

@section('title')
长耳兔 | 后台登录
@stop

@section('body')
<body class="login">
	<section id="page">
			<header>
				<div class="container">
					<div class="row">
						<div class="col-md-4 col-md-offset-4">
							<div id="logo">
								<img src="{{URL::asset('static/admin/img/logo-alt.png')}}" height="40" alt="logo name" />
							</div>
						</div>
					</div>
				</div>
			</header>
			<section id="login" class="visible">
				<div class="container">
					<div class="row">
						<div class="col-md-4 col-md-offset-4">
							<div class="login-box-plain">
								<h2 class="bigintro">登录</h2>
								<div class="divide-40"></div>
								<form role="form" action="{{url('admin/doLogin')}}" method="post">
								  <div class="form-group">
									<label>用户名：</label>{{$errors->first('UserName')}}
									<i class="fa fa-user"></i>
									<input type="text" class="form-control" name="UserName" placeholder="用户名由6-16个字母和数字组成">
								  </div>
								  <div class="form-group"> 
									<label>密码：</label>{{$errors->first('PassWord')}}
									<i class="fa fa-lock"></i>
									<input type="password" class="form-control" name="PassWord" placeholder="密码长度6-20个字符">
								  </div>
								  <div class="form-actions">
									<button type="submit" class="btn btn-danger">登录</button>
								  </div>
								  <input type="hidden" name="_token" value="{{csrf_token()}}"/>
								</form>
							</div>
						</div>
					</div>
				</div>
			</section>
	</section>
</body>
@stop