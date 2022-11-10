<div class="row">
    <div class="col-12 col-sm-12 col-md-12 col-lg-12">
        <div class="section-title">
            <h3>Thông tin đặt hàng</h3>
        </div>
        <form action="#">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <td>Ảnh</td>
                            <td>Tên</td>
                            <td>Số lượng</td>
                            <td width="150px">Giá</td>
                            <td width="150px">Tổng</td>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($products as $item)
                            <tr>
                                <td >
                                    <a href="{{ $item->Product->Url }}"><img style="width: 50px" src="{{ URL::asset($item->Product->Image) }}" alt="{{ $item->Product->ShortName }}" title="{{ $item->Product->ShortName }}"></a>
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
                                            <input type="number"  name="{{ $item->ProductId }}" class="input-quantity" value="{{ $item->Quantity }}" readonly>
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
    </div>
</div>

