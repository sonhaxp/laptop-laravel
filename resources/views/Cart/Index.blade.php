@extends('Shared.layout');
@section('title', 'Giỏ hàng')
@section('content')
<!-- Begin-main -->
<!-- breadcrumb area start -->
<div class="breadcrumb-area mb-30">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="breadcrumb-wrap">
                    <nav aria-label="breadcrumb">
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ URL::asset('/trang-chu') }}">Trang chủ</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Giỏ hàng</li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- breadcrumb area end -->
<div id="render-cart">
    @if ($products->count()>0)
    @include('cart.cart')
    @else
        <h2 style="text-align: center; color: red">Chưa có sản phẩm nào trong giỏ hàng</h1>
    @endif
</div>

@endsection
