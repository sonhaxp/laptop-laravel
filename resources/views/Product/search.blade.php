<div class="shop-product-wrap grid column_3 row">
    @foreach ($products as $item)
        <div class="col-lg-3 col-md-4 col-sm-6">
            <div class="product-item mb-30">
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
            </div> <!-- end single grid item -->
            {{-- <div class="sinrato-list-item mb-30">
                <div class="sinrato-thumb">
                    <a href="/san-pham/@i.Product_Id">
                        <img src="~/Content/img/product/@i.Image" class="pri-img" alt="@i.Product_Name">
                    </a>
                    <div class="box-label">
                        @if (i.Product_Discount > 0)
                        {
                            <div class="label-product label_sale">
                                <span>-@i.Product_Discount%</span>
                            </div>
                        }
                    </div>
                </div>
                <div class="sinrato-list-item-content">
                    <div class="manufacture-product">
                        <p><a href="">@i.Manufacturer.Manufacturer_Name</a></p>
                    </div>
                    <div class="sinrato-product-name">
                        <h4><a href="product-details.html">@i.Product_ShortName</a></h4>
                    </div>
                    <div class="sinrato-ratings mb-15">
                        @{
                            for (int k = 0; k < rateStar; k++)
                            {
                                <span class="yellow"><i class="lnr lnr-star"></i></span>
                            }
                            for (int k = rateStar; k < 5; k++)
                            {
                                <span><i class="lnr lnr-star"></i></span>
                            }
                            <span>@i.Rate_Star/5</span>
                        }
                    </div>
                    <div class="sinrato-product-des">
                        <p>@i.Product_Description</p>
                    </div>
                </div>
                <div class="sinrato-box-action">
                    <div class="price-box">
                        <span class="regular-price"><span class="special-price">@String.Format("{0:0,00} vnđ", i.Product_Price - i.Product_Price * i.Product_Discount / 100)</span></span>
                        <span class="old-price"><del>@String.Format("{0:0,00} vnđ", i.Product_Price)</del></span>
                    </div>
                    <button class="btn-cart" name="@i.Product_Id" type="button">Thêm vào giỏ</button>
                    <div class="action-links sinrat-list-icon">
                        <div class="btn-wishlist wish-list-@i.Product_Id" name="@i.Product_Id" title="yêu thích"><i class="lnr lnr-heart"></i></div>
                    </div>
                </div>
            </div> <!-- end single list item --> --}}
        </div>
    @endforeach
</div> 