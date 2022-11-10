@extends('Shared.layout');
@section('title', 'Sản phẩm')
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
                            <li class="breadcrumb-item active" aria-current="page">{{ $category->Name }}</li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</div>
@if ($products->count()!=0)
    <div class="main-wrapper pt-35">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-3">
                    <div class="shop-sidebar-inner mb-30">
                        <!-- categories filter start -->
                        <div class="single-sidebar mb-45">
                            <div class="sidebar-inner-title mb-25">
                                <h3>Hãng sản xuất</h3>
                            </div>
                            <div class="sidebar-content-box">
                                <div class="filter-attribute-container">
                                    <ul>
                                        <li><div class="active filter-manufacturer" per="0">Tất cả</div></li>
                                        @foreach ($brand as $item)
                                            <li><div class="filter-manufacturer" per="{{ $item->BrandId }}">{{ $item->Brand->Name }}</div></li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <!-- categories filter end -->
                        <!-- categories filter start -->
                        <div class="single-sidebar mb-45">
                            <div class="sidebar-inner-title mb-25">
                                <h3>Mức giá</h3>
                            </div>
                            <div class="sidebar-content-box">
                                <div class="filter-attribute-container">
                                    <ul>
                                        <li><div class="active filter-price" per="0">Tất cả</div></li>
                                        <li><div class="filter-price" per="1">Dưới 10 triệu</div></li>
                                        <li><div class="filter-price" per="2">Từ 10 đến 15 triệu</div></li>
                                        <li><div class="filter-price" per="3">Từ 15 đến 20 triệu</div></li>
                                        <li><div class="filter-price" per="4">Từ 20 đến 25 triệu</div></li>
                                        <li><div class="filter-price" per="5">Trên 25 triệu</div></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <!-- categories filter start -->
                        <!-- categories filter start -->
                        {{-- <div class="single-sidebar mb-45">
                            <div class="sidebar-inner-title mb-25">
                                <h3>Nhu cầu</h3>
                            </div>
                            <div class="sidebar-content-box">
                                <div class="filter-attribute-container">
                                    <ul>
                                        <li><div class="active filter-need" per="0">Tất cả</div></li>
                                        @foreach (var i in needs)
                                        {
                                            <li><div class="filter-need" per="@i.Need_Id">@i.Need_Name</div></li>
                                        }
                                    </ul>
                                </div>
                            </div>
                        </div> --}}
                    </div>
                </div>
                
                <div class="col-lg-9 order-first order-lg-last">
                    <div class="product-shop-main-wrapper mb-50">
                        <div class="shop-top-bar mb-30">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="top-bar-left">
                                        <div class="product-view-mode">
                                            <a class="active" href="#" data-target="column_3"><span>3-col</span></a>
                                            <a href="#" data-target="grid"><span>4-col</span></a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="top-bar-right">
                                        <div class="product-short">
                                            <p>Sắp xếp theo : </p>
                                            <select class="nice-select" onchange="sort(this);" name="sortby">
                                                <option value="0">Bán chạy nhất</option>
                                                <option value="1">Giá từ thấp đến cao</option>
                                                <option value="2">Giá từ cao đến thấp</option>
                                                <option value="3">Đánh giá cao</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div id="product-product-main">
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
                            @if ($page>1)
                            <div id="paging">
                                <div class="btn btn-primary btn-paging filter active">1</div>
                                @for ($i = 2; $i <= $page; $i++)
                                    <div class="btn btn-primary btn-paging filter">{{ $i }}</div>
                                @endfor
                            </div>   
                            @endif               
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@else
    <div><h2 style="text-align: center; color: red;">Chưa có sản phẩm nào thuộc danh mục này</h2></div>
@endif
<form action="filterProduct" method="post">
    @csrf
    <input type="text" hidden name="category" value="{{ $category->CategoryId }}">
</form>
<script src="{{ URL::asset('js/home.js') }}"></script>
<script>
    var brand = [];
    var orderby = 0;
    var price = [];
    var page_product = 1;
    sort = function (sel) {
        orderby = sel.value;
        getProduct(1, brand, price, orderby);
    }
    $(document).on("click", ".filter-manufacturer", function () {
        var id = $(this).attr('per');
        if (id == 0) {
            if (!$(this).hasClass('active')) {
                $('.filter-manufacturer').removeClass('active');
                brand = [];
                $(this).addClass('active');
            }
        }
        else {
            if ($(this).hasClass('active') == true) {
                temp = [];
                for (var i = 0; i < brand.length; i++) {
                    if (brand[i] != id) {
                        temp.push(brand[i]);
                    }
                }
                brand = temp;
                $(this).removeClass('active');
            }
            else {
                $('.filter-manufacturer').get(0).classList.remove('active')
                $(this).addClass('active');
                brand.push(id)
            }
        }
        if (brand.length==0) $('.filter-manufacturer').get(0).classList.add('active')
        getProduct(1, brand, price, orderby);
    });
    $(document).on("click", ".filter-price", function () {
        var id = $(this).attr('per');
        if (id == 0) {
            if (!$(this).hasClass('active')) {
                $('.filter-price').removeClass('active');
                price = [];
                $(this).addClass('active');
            }
        }
        else {
            if ($(this).hasClass('active') == true) {
                temp = [];
                for (var i = 0; i < price.length; i++) {
                    if (price[i] != id) {
                        temp.push(price[i]);
                    }
                }
                price = temp;
                $(this).removeClass('active');
            }
            else {
                $('.filter-price').get(0).classList.remove('active')
                $(this).addClass('active');
                price.push(id)
            }
        }
        if (price.length==0) $('.filter-price').get(0).classList.add('active')
        getProduct(1, brand, price, orderby);
    });
    getProduct = function (page_product, brand, price, orderby) {
        let _token = $('input[name="_token"]').val();
        let category = $('input[name="category"]').val();
        var form = new FormData();
        form.append("_token", _token);
        form.append("brand", brand.toString())
        form.append("price", price.toString())
        form.append("page", page_product)
        form.append("orderby", orderby)
        form.append("category", category)
        $.ajax({
            url: "filterProduct",
            data: form,
            method: "POST",
            contentType: false,
            processData: false,
            success: function (res) {
                $("#product-product-main").html(res);
                $('.btn-paging.active').removeClass('active');
                $('.btn-paging').get(page_product-1).classList.add('active')
            },
            error: function () {
                console.log("Load api get thất bại");
            }
        });
    }
    $(document).on("click", ".btn.btn-primary.btn-paging.filter", function () {
        page_product = $(this).html();
        getProduct(page_product, brand, price, orderby);
    })
</script>
@endsection