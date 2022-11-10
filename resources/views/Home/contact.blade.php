@extends('Shared.layout');
@section('title', 'Liên hệ')
@section('content')
<!-- breadcrumb area start -->
<div class="breadcrumb-area mb-30">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="breadcrumb-wrap">
                    <nav aria-label="breadcrumb">
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="/trang-chu">Trang chủ</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Liên hệ</li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- breadcrumb area end -->

<!-- contact us area -->
<section class="contact-style-2 pt-30 pb-35">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="contact2-title text-center mb-65">
                    <h2>Liên hệ</h2>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-4 col-md-6 col-sm-6">
                <div class="contact-single-info mb-30 text-center">
                    <div class="contact-icon">
                        <i class="fa fa-map-marker"></i>
                    </div>
                    <h3>Cửa hàng</h3>
                    <p>Địa chỉ : {{ $configSite->Place }}</p>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 col-sm-6">
                <div class="contact-single-info mb-30 text-center">
                    <div class="contact-icon">
                        <i class="fa fa-phone"></i>
                    </div>
                    <h3>Số điện thoại</h3>
                    <p><a href="tel:+{{ $configSite->Hotline }}">{{ $configSite->Hotline }}</a></p>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 col-sm-6">
                <div class="contact-single-info mb-30 text-center">
                    <div class="contact-icon">
                        <i class="fa fa-envelope"></i>
                    </div>
                    <h3>Email</h3>
                    <p><a href="mailto:{{ $configSite->Email }}">{{ $configSite->Email }}</a></p>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection