<div class="shopping-cart-wrapper pb-70">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                <main id="primary" class="site-main">
                    <div class="shopping-cart">
                        <div class="row">
                            <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="section-title">
                                    <h3>Giỏ hàng</h3>
                                </div>
                                <form action="#">
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <td>Ảnh</td>
                                                    <td>Tên</td>
                                                    <td>Số lượng</td>
                                                    <td>Giá</td>
                                                    <td>Tổng</td>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($products as $item)
                                                <tr>
                                                    <td>
                                                        <a href="{{ $item->Product->Url }}"><img src="{{ URL::asset($item->Product->Image) }}" alt="{{ $item->Product->ShortName }}" title="{{ $item->Product->ShortName }}"></a>
                                                    </td>
                                                    <td>
                                                        <a href="{{ $item->Product->Url }}">{{ $item->Product->ShortName }}</a>
                                                        @if ($item->Product->Attribute!=null)
                                                            @foreach ($item->Product->Attribute as $temp)
                                                                <p>{{ $temp->name }}: {{ $temp->value }}</p>
                                                            @endforeach
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <div class="input-group btn-block">
                                                            <div class="product-qty mr-3">
                                                                <input type="number" name="{{ $item->OrderDetailId }}" class="input-quantity" value="{{ $item->Quantity }}" readonly>
                                                                <span class="dec qtybtn"><i class="fa fa-minus"></i></span><span class="inc qtybtn"><i class="fa fa-plus"></i></span>
                                                            </div>
                                                            <div class="input-group-btn">
                                                                <div class="btn btn-danger pull-right btn-action btn-delete-cart" name='{{ $item->OrderDetailId }}'><i class="fa fa-times-circle"></i></div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="price">
                                                            <small><del>>{{ number_format($item->Price, 0, '', ',')."vnđ"}}</del></small> <br>
                                                            <strong>{{ number_format($item->Price * (100 - $item->Discount) / 100, 0, '', ',')."vnđ"}}</strong>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        {{ number_format($item->Price * $item->Quantity *(100 - $item->Discount) / 100, 0, '', ',')."vnđ"}}
                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </form>
                                <div class="cart-amount-wrapper">
                                    <div class="row">
                                        <div class="col-12 col-sm-12 col-md-4 offset-md-8">
                                            <table class="table table-bordered">
                                                <tbody>
                                                    <tr>
                                                        <td><strong>Tổng tiền:</strong></td>
                                                        <td><span class="color-primary">{{ number_format($total, 0, '', ',')."vnđ" }}</span></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>

                                <div class="cart-button-wrapper d-flex justify-content-between mt-4">
                                    <a href="/trang-chu" class="btn btn-primary">Tiếp tục mua</a>
                                    <a href="/thanh-toan" class="btn btn-primary dark align-self-end">Thanh toán</a>
                                </div>
                            </div>
                        </div>
                    </div> <!-- end of shopping-cart -->
                </main> <!-- end of #primary -->
            </div>
        </div> <!-- end of row -->
    </div> <!-- end of container -->
</div>
<script src="{{ URL::asset('js/cart.js') }}"></script>