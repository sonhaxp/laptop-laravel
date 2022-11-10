<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Đăng nhập</title>	
    <link rel="stylesheet" href="{{ URL::asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('css/login.css') }}">
    <style>
        label.error{
            color: red;
            margin-left: 20px;
        }
    </style>
	<script src="//code.jquery.com/jquery-1.11.3.min.js"></script>
	<script type="text/javascript" src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.13.1/jquery.validate.min.js"></script>
</head>
<body>
	<div class="container">
        <div class="row">
            <div class="col-sm-12 col-lg-4 pr-4 order-lg-0 order-1">
            </div>
            <div class="col-sm-12 col-lg-4 order-lg-0 order-1" style="background: rgb(255, 255, 255)">
                <div class="limiter mt-lg-5 pt-3">
                    <div class="wrap-login100">
                        <div class="title"><h2>Đăng nhập</h2></div>
                            <form action="/admin/checkLogin" method="post" id="LoginForm">
                                @csrf
                                @if ($errors->has('email')==true)
                                    <div class="login-box mt-5 text-center">
                                        <p style="color:red"><strong>{{ $errors->first('email') }}</strong></p>
                                    </div>    
                                @endif
                                <div class="input-group">
                                    <span class="mt-3 user-name">Tài khoản</span>
                                    <input id="UserName" name="UserName" placeholder="*Nhập mật khẩu" type="text">
                                </div>
                                <div class="input-group">
                                    <span class="mt-3 user-name">Mật khẩu</span>
                                    <input id="Password" name="Password" placeholder="*Nhập mật khẩu" type="password">
                                </div>
                                <button type="submit" class="login100-form-btn">
                                    Đăng nhập
                                </button>
                            </form>
                        <hr />
                    </div>
                </div>
            </div>
            <div class="col-sm-12 col-lg-4 pr-4 order-lg-0 order-1">
            </div>
        </div>
    </div>
	<script type="text/javascript">
	$(document).ready(function() {
		$("#LoginForm").validate({
			rules: {
				UserName: {
                    required: true,
                },
				Password:{
                    required: true,
                    minlength: 6
                }
			},
			messages: {
				UserName: {
					required: "Tài khoản không được để trống",
				},
				Password: {
					required: "Mật khẩu không được để trống",
					minlength: "Mật khẩu phải từ 6 kí tự trở lên"
				}
			}
		});
	});
	</script>
</body>
</html>