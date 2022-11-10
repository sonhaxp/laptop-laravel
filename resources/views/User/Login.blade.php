@extends('Shared.layout');
@section('title', 'Đăng nhập')
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
                            <li class="breadcrumb-item active" aria-current="page">Đăng nhập</li>
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
                                    <h3>Đăng nhập</h3>
                                </div>
                            </div>
                        </div> <!-- end of row -->
                        <div class="row">
                            <div class="col-12 col-sm-12 col-md-12 col-lg-8 col-xl-6 offset-lg-2 offset-xl-3">
                                <div class="login-form">
                                    <form method = "POST" action="checkLogin">
                                       @csrf
                                        <div class="form-group row align-items-center mb-4">
                                            <label for="email" class="col-12 col-sm-12 col-md-4 col-form-label">Email</label>
                                            <div class="col-12 col-sm-12 col-md-8">
                                                <input type="text" class="form-control" name="username" id="email" placeholder="Email" required>
                                            </div>
                                        </div>
                                        <div class="form-group row align-items-center mb-4">
                                            <label for="c-password" class="col-12 col-sm-12 col-md-4 col-form-label">Mật khẩu</label>
                                            <div class="col-12 col-sm-12 col-md-8">
                                                <input type="password" class="form-control" name="password" id="password" placeholder="Mật khẩu" required>
                                                <button class="pass-show-btn" type="button">Hiện</button>
                                            </div>
                                        </div>
                                        @if ($errors->has('email')==true)
                                        {{-- <script>alert('Sai tên đăng nhập hoặc mật khẩu')</script> --}}
                                        <div class="login-box mt-5 text-center">
                                            <p style="color:red"><strong>{{ $errors->first('email') }}</strong></p>
                                        </div>    
                                        {{-- <span class="invalid-feedback">
                                                <strong>{{ $errors->first('email') }}</strong>
                                            </span> --}}
                                        @endif
                                        <div class="login-box mt-5 text-center">
                                            <p><a href="#">Quên mật khẩu?</a></p>
                                            <button type="submit" class="btn btn-secondary mb-4 mt-4 btn-submit-login">Đăng nhập</button>
                                        </div>
                                        <div class="text-center pt-20 top-bordered">
                                            <p>Không có tài khoản? <a href="/dang-ki">Đăng kí tại đây</a>.</p>
                                        </div>
                                    </div>
                            </div>
                        </div>
                    </div> <!-- end of user-login -->
                </main> <!-- end of #primary -->
            </div>
        </div> <!-- end of row -->
    </div> <!-- end of container -->
</div>
    <script src="{{ URL::asset('js/login.js') }}"></script>
@endsection
