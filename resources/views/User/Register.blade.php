@extends('Shared.layout');
@section('title', 'Đăng kí')
@section('content')
<!-- breadcrumb area start -->
<div class="breadcrumb-area mb-30">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="breadcrumb-wrap">
                    <nav aria-label="breadcrumb">
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ URL::asset('/trang-chu') }}">Trang chủ</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Đăng ký</li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- breadcrumb area end -->
<div class="login-wrapper pb-70">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                <main id="primary" class="site-main">
                    <div class="user-login">
                        <div class="row">
                            <div class="col-12 col-sm-12 col-md-12">
                                <div class="section-title text-center">
                                    <h3>Tạo tài khoản</h3>
                                </div>
                            </div>
                        </div> <!-- end of row -->
                        <div class="row">
                            <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-8 offset-xl-2">
                                <div class="registration-form login-form">
                                    <form action="registerUser" method="post">
                                        @csrf
                                        <div class="login-info mb-20">
                                            <p>Nếu đã có tài khoản? <a href="/dang-nhap">Đăng nhập tại đây!</a></p>
                                        </div>
                                        @if ($errors->has('email')==true)
                                            <div class="login-box mt-5 text-center">
                                                <p style="color:red"><strong>{{ $errors->first('email') }}</strong></p>
                                            </div>
                                        @endif
                                        <div class="form-group row">
                                            <label for="f-name" class="col-12 col-sm-12 col-md-4 col-form-label">Họ tên</label>
                                            <div class="col-12 col-sm-12 col-md-8 col-lg-8">
                                                <input type="text" class="form-control" id="name" name = "name">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="email" class="col-12 col-sm-12 col-md-4 col-form-label">Email</label>
                                            <div class="col-12 col-sm-12 col-md-8 col-lg-8">
                                                <input type="text" class="form-control" id="email" name="email">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="newpassword" class="col-12 col-sm-12 col-md-4 col-form-label">Mật khẩu</label>
                                            <div class="col-12 col-sm-12 col-md-8 col-lg-8">
                                                <input type="password" class="form-control" id="newpassword" name="password">
                                                <button class="pass-show-btn" id="hide-newpass" type="button">Hiện</button>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="c-password" class="col-12 col-sm-12 col-md-4 col-form-label">Nhập lại mật khẩu</label>
                                            <div class="col-12 col-sm-12 col-md-8 col-lg-8">
                                                <input type="password" class="form-control" id="c-password" name="password2">
                                                <button class="pass-show-btn" id="hide-c-pass" type="button">Hiện</button>
                                            </div>
                                        </div>
                                        <div class="form-group row align-items-center">
                                            <label class="col-12 col-sm-12 col-md-4 col-form-label" name = "gender">Giới tính</label>
                                            <div class="col-12 col-sm-12 col-md-8 col-lg-8">
                                                <div class="form-row">
                                                    <div class="col-6 col-sm-3">
                                                        <div class="custom-radio">
                                                            <input class="form-check-input" type="radio" name="gender" id="male" value="Nam">
                                                            <span class="checkmark"></span>
                                                            <label class="form-check-label" for="male">Nam</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-6 col-sm-3">
                                                        <div class="custom-radio">
                                                            <input class="form-check-input" type="radio" name="gender" id="female" value="Nữ">
                                                            <span class="checkmark"></span>
                                                            <label class="form-check-label" for="female">Nữ</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="birth" class="col-12 col-sm-12 col-md-4 col-form-label" >Ngày sinh</label>
                                            <div class="col-12 col-sm-12 col-md-8 col-lg-8">
                                                <input type="date" class="form-control" id="birth" placeholder="MM / DD / YYYY" name="birthday">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="address" class="col-12 col-sm-12 col-md-4 col-form-label" >Địa chỉ</label>
                                            <div class="col-12 col-sm-12 col-md-8 col-lg-8">
                                                <input type="text" class="form-control" id="address" name="address">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="phonenumber" class="col-12 col-sm-12 col-md-4 col-form-label">Điện thoại</label>
                                            <div class="col-12 col-sm-12 col-md-8 col-lg-8">
                                                <input type="text" class="form-control" id="phonenumber" name="phone">
                                            </div>
                                        </div>
                                        
                                        <div class="register-box d-flex justify-content-end mt-20">
                                            <button type="submit" class="btn btn-secondary btn-submit-register">Đăng kí</button>
                                        </div>
                                        
                                    </form>    
                                </div>
                            </div>
                        </div>
                    </div> <!-- end of user-login -->
                </main> <!-- end of #primary -->
            </div>
        </div> <!-- end of row -->
    </div> <!-- end of container -->
</div>
<script src="{{ URL::asset('js/register.js') }}"></script>
@endsection
