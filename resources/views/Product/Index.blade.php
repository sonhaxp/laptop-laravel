@extends('Shared.Layout')
@section('title', $product->ShortName)
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
                                @if ($category!=null)
                                <li class="breadcrumb-item"><a href="{{ URL::asset($category->Url) }}">{{ $category->Name }}</a></li>
                                @endif
                                <li class="breadcrumb-item active" aria-current="page">{{ $product->ShortName }}</li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- breadcrumb area end -->
    @if ($errors->has('role')==true)
        <div class="login-box mt-5 text-center">
            <p style="color:red"><strong>{{ $errors->first('role') }}</strong></p>
        </div>    
        @endif
    <!-- product details wrapper start -->
    <div class="product-details-main-wrapper pb-50">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-5">
                    <div class="product-large-slider mb-20">
                        <div class="pro-large-img">
                            <img src="{{ URL::asset($product->Image) }}" alt="" />
                            {{-- <div class="img-view">
                                <a class="img-popup" href="{{ URL::asset($product->Image) }}"><i class="fa fa-search"></i></a>
                            </div> --}}
                            
                        </div>
                        
                    </div>
                    <div class="pro-nav">
                        
                    </div>
                </div>
                <div class="col-lg-7">
                    <div class="product-details-inner">
                        <div class="product-details-contentt">
                            <div class="pro-details-name mb-10">
                                <h3>{{$product->Name}}</h3>
                            </div>
                            <div class="pro-details-review mb-20">
                                <ul>
                                    <li>
                                        @php
                                            $rateStar = round($rate_Rate,0);
                                            for ($k = 1; $k <= $rateStar; $k++)
                                            {
                                                echo '<span><i class="fa fa-star" style="color: #fedc19!important;"></i></span>';
                                            }
                                            for ($k = $rateStar; $k <5; $k++)
                                            {
                                                echo '<span><i class="fa fa-star"></i></span>';
                                            }
                                        @endphp
                                        <span>{{ number_format($rate_Rate ,1)}}</span>
                                    </li>
                                    <li>{{ $rate_Count." đánh giá" }}</li>
                                </ul>
                            </div>
                            <div class="price-box mb-15">
                                <span class="regular-price"><span class="special-price">{{number_format($product->Price * (100-($product->Discount==null?0:$product->Discount)) / 100, 0, '', ',')."vnđ"}}</span></span>
                                <span class="old-price"><del>{{ number_format($product->Price, 0, '', ',')."vnđ"}}</del></span>
                            </div>
                            <div class="product-detail-sort-des pb-20">
                                <p><b>Thương hiệu: </b> {{$product->Brand->Name}}</p>
                                <div class="pro-details-list pt-20">
                                    <ul>
                                        @foreach ($attribute as $item)
                                        <li><span>{{ $item->Attribute->Name }} :</span>{{ $item->AttributeValue->Value }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                            @if ($classifygroup!=null)
                            <div class="product-availabily-option mt-15 mb-15">
                                @foreach ($classifygroup as $item)
                                <div>
                                    <h4><sup>*</sup>{{ $item->attribute->Name }}</h4>
                                    <ul style="display: flex">
                                        @foreach ($item->classifygroupoptions as $option)
                                        <li>
                                            @if ($option->ClassifyGroupOptionId == $product->Group1 || $option->ClassifyGroupOptionId == $product->Group2)
                                            <a href="{{URL::asset($option->product->Url)}}" class="btn border border-primary" style="margin-right: 10px">{{ $option->attributevalue->Value }}</a>
                                            @else
                                            <a href="{{URL::asset($option->product->Url)}}" class="btn border" style="margin-right: 10px">{{ $option->attributevalue->Value }}</a>
                                            @endif
                                        </li>
                                        @endforeach
                                    </ul> 
                                </div>
                                @endforeach
                            </div>
                            @endif
                            <div class="pro-quantity-box mb-30">
                                <form method="POST" action="{{ URL::asset("AddCart") }}">
                                    @csrf
                                    <input type="text" hidden name="idProduct" id="" value="{{ $product->ProductId }}">
                                <div class="qty-boxx">
                                    <button class="btn-cart lg-btn" type="submit">Thêm vào giỏ hàng</button>
                                </div>
                            </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- product details wrapper end -->

    <!-- product details reviews start -->
    <div class="product-details-reviews pb-30">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="product-info mt-half">
                        <ul class="nav nav-pills justify-content-center" id="pills-tab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="nav_desctiption" data-toggle="pill" href="#tab_description" role="tab" aria-controls="tab_description" aria-selected="true">Mô tả</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="nav_review" data-toggle="pill" href="#tab_review" role="tab" aria-controls="tab_review" aria-selected="false">Đánh giá ({{ $rate_Count }})</a>
                            </li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane fade show active" id="tab_description" role="tabpanel" aria-labelledby="nav_desctiption">
                                <p>{{ $product->Description }}</p>
                            </div>
                            <div class="tab-pane fade" id="tab_review" role="tabpanel" aria-labelledby="nav_review">
                                <div class="product-review">
                                    <form action="/Rate" method="POST" class="review-form">
                                        @csrf
                                        <h2>Đánh giá</h2>
                                        <input name="productId" type="text" class="form-control" value={{ $product->ProductId }} style="display: none;">
                                        <div class="form-group row">
                                            <div class="col">
                                                <label class="col-form-label"><span class="text-danger">*</span> Cảm nhận của bạn về sản phẩm</label>
                                                <textarea name = "comment" class="form-control" required></textarea>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col">
                                                <label class="col-form-label"><span class="text-danger">*</span> Đánh giá</label>
                                                &nbsp;&nbsp;&nbsp; Tệ&nbsp;
                                                <input type="radio" value="1" name="rating">
                                                &nbsp;
                                                <input type="radio" value="2" name="rating">
                                                &nbsp;
                                                <input type="radio" value="3" name="rating">
                                                &nbsp;
                                                <input type="radio" value="4" name="rating">
                                                &nbsp;
                                                <input type="radio" value="5" name="rating" checked>
                                                &nbsp;Tuyệt vời
                                            </div>
                                        </div>
                                        <div class="buttons d-flex justify-content-end">
                                            <button class="btn-cart rev-btn" type="submit">Gửi đánh giá</button>
                                        </div>
                                    </form> <!-- end of review-form -->
                                    @foreach ($rate as $item)
                                    <div class="customer-review">
                                        <table class="table table-striped table-bordered">
                                            <tbody>
                                                <tr>
                                                    <td><strong>{{ $item->User->Name }}</strong></td>
                                                    <td class="text-right">{{ date("d/m/Y", strtotime($item->CreateAt));}}</td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2">
                                                        <p>{{ $item->Comment}}</p>
                                                        <div class="product-ratings">
                                                            <ul class="ratting d-flex mt-2">
                                                                @php
                                                                    $rateStar = $item->Star;
                                                                    for ($k = 1; $k <= $rateStar; $k++)
                                                                    {
                                                                        echo '<li><i class="fa fa-star" style="color: #fedc19!important;"></i></li>';
                                                                    }
                                                                    for ($k = $rateStar; $k <5; $k++)
                                                                    {
                                                                        echo '<li><i class="fa fa-star"></i></li>';
                                                                    }
                                                                @endphp     
                                                            </ul>
                                                        </div>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    @endforeach
                                     <!-- end of customer-review -->
                                </div> <!-- end of product-review -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>  
    
    <script>
        // $(document).on("click", ".btn-cart", function () {
        //     var id = $(this).attr("name")
        //     window.location = "/Cart/AddCart/" + id;
        // });
    </script>    
@endsection
