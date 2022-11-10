@extends('shared.admin.layout')
@section('title', 'Trang quản trị')
@section('content')
<div class="top-title">
    <div class="media">
        <p><i class="fal fa-home-lg-alt"></i></p>
        <div class="media-body">
            <h5 class="mt-3">Tổng quan</h5>
        </div>
    </div>
</div>
<div class="row mt-4">
    <div class="col-sm-12 col-md-6 col-lg-3 mt-md-5 mt-3">
        <div class="overview-item">
            <div class="icon icon-video"> <i class="fal fa-box"></i></div>
            <a class="stretched-link" href="{{ URL::asset("product/ListProduct") }}">Sản phẩm</a>
            <p class="counter">{{ $countProduct }}</p>
            <div class="info">
                <i class="far fa-history mr-1"></i> Cập nhật mới nhất
            </div>
        </div>
    </div>
    <div class="col-sm-12 col-md-6 col-lg-3 mt-md-5 mt-3">
        <div class="overview-item">
            <div class="icon icon-cart"><i class="fal fa-newspaper"></i></div>
            <a class="stretched-link" href="/article/ListArticle">Tin tức</a>
            <p class="counter">{{ $countArticle }}</p>
            <div class="info">
                <i class="far fa-history mr-1"></i> Cập nhật mới nhất
            </div>
        </div>
    </div>
    <div class="col-sm-12 col-md-6 col-lg-3 mt-md-5 mt-3">
        <div class="overview-item">
            <div class="icon icon-product"> <i class="fal fa-comments"></i></div>
            <a class="stretched-link" href="/admin/ListFeeback">Phản hồi</a>
            <p class="counter">{{ $countFeedBack }}</p>
            <div class="info">
                <i class="far fa-history mr-1"></i> Cập nhật mới nhất
            </div>
        </div>
    </div>
    <div class="col-sm-12 col-md-6 col-lg-3 mt-md-5 mt-3">
        <div class="overview-item">
            <div class="icon icon-city"><i class="fal fa-user"></i></div>
            <a class="stretched-link" href="/user/ListCustomer">Khách hàng</a>
            <p class="counter">{{ $countCustomer }}</p>
            <div class="info">
                <i class="far fa-history mr-1"></i> Cập nhật mới nhất
            </div>
        </div>
    </div>
    <div class="col-sm-12 col-md-6 col-lg-3 mt-md-5 mt-3">
        <div class="overview-item">
            <div class="icon icon-article"> <i class="fal fa-industry"></i></div>
            <a class="stretched-link" href="/brand/createBrand">Thương hiệu</a>
            <p class="counter">{{ $countBrand }}</p>
            <div class="info">
                <i class="far fa-history mr-1"></i> Cập nhật mới nhất
            </div>
        </div>
    </div>
</div>
@endsection