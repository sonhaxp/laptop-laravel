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
                            <li class="breadcrumb-item active" aria-current="page">Giới thiệu</li>
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
                    <h2>Giới thiệu</h2>
                    <h3>{{ $configSite->Title }}</h3>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <p>
                @php
                    $list = explode("<br>", $configSite->Description);
    
                    foreach($list as $item){
                        echo $item;
                        echo '<br><br>';
                    }
                @endphp
                </p>
            </div>
        </div>
    </div>
</section>
@endsection