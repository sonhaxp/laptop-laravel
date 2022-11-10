@extends('Shared.Layout')
@section('title', 'Trang chủ')
@section('content')
    <?php use App\Http\Controllers\HomeController;
    echo HomeController::renderSlider()?>
    <div class="home2-main-wrapper mt-30">
        <div class="container-fluid">
            @php
                echo HomeController::renderLaptopBestSeller();
                // echo HomeController::renderPhoneBestSeller()
                echo HomeController::renderLaptopBestDiscount();
            @endphp
        </div>
    </div>
@endsection
