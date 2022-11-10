<!-- slider area start -->
<div class="slider-area mt-30">
    <div class="container-fluid">
        <div class="hero-slider-active slick-dot-style slider-arrow-style">
            @foreach ($slider as $item)
                <div class="single-slider slider3 d-flex align-items-center" style="background-image: url({{ URL::asset($item->Image) }});">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-sm-6 col-sm-8">
                                <div class="slider-text">
                                    <h1>{{ $item->BannerName }}</h1>
                                    <p>{{ $item->Slogan }}</p>
                                    <a class="btn-1 home-btn" href="{{ URL::asset($item->Url) }}">{{$item->BtnText}}</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
<!-- slider area end -->