<div class="row">
    <div class="col-lg-12 order-first order-lg-last">
        <div class="home2-content-wrapper">
            <div class="product-wrapper fix pb-75">
                <div class="container-fluid plr-none">
                    <div class="section-title product-spacing home2-tab-spacing" style="
                    display: flex;
                    justify-content: space-between;
                ">
                        <h3><span>{{ $title }}</span></h3>
                        <a href="{{ URL::asset($link) }}" style="display: flex; align-items: center; background: yellow; border: 1px solid; border-radius: 40px;">Xem tất cả</a>
                    </div>
                    <div class="row">
                        @foreach ($product as $item)
                            <div class="product-item  col-sm-3">
                                <div class="product-thumb">
                                    <a href="{{ URL::asset($item->Url) }}">
                                        <img src="{{ URL::asset($item->Image) }}" class="pri-img" alt="{{ $item->Description }}">
                                    </a>
                                    <div class="box-label">
                                        @if ($item->Discount > 0 && $item->Discount != null)
                                            <div class="label-product label_sale">
                                                <span>{{ $item->Discount }}%</span>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="product-caption">
                                    <div class="manufacture-product">
                                        <p>{{ $item->Brand->Name }}</p>
                                    </div>
                                    <div class="product-name">
                                        <h4><a href="{{ URL::asset($item->Url) }}">{{ $item->ShortName }}</a></h4>
                                    </div>
                                    <div class="ratings">
                                        {{-- @{
                                            int rateStar = (int)Math.Round((double)i.Rate_Star);
                                            for (int k = 0; k < rateStar; k++)
                                            {
                                                <span class="yellow"><i class="lnr lnr-star"></i></span>
                                            }
                                            for (int k = rateStar; k < 5; k++)
                                            {
                                                <span><i class="lnr lnr-star"></i></span>
                                            }
                                            <span>@i.Rate_Star/5</span>
                                        } --}}
                                    </div>
                                    <div class="price-box">
                                        <span class="regular-price"><span class="special-price">{{number_format($item->Price * (100-($item->Discount==null?0:$item->Discount)) / 100, 0, '', ',')."vnđ"}}</span></span>
                                        <span class="old-price"><del>{{ number_format($item->Price, 0, '', ',')."vnđ"}}</del></span>
                                    </div>
                                    {{-- <button class="btn-cart" name="@i.Product_Id" type="button">Thêm vào giỏ</button> --}}
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>