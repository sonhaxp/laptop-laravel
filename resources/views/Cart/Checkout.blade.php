@extends('Shared.Layout')
@section('title', 'Thanh toán')
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
                                <li class="breadcrumb-item"><a href="{{ URL::asset('/gio-hang') }}">Giỏ hàng</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Thanh toán</li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
<form action="/completePayment" method="POST">
    @csrf
<div class="container-fluid">
    <div class="checkout-area">
        <div class="row">
            <div class="col-12 col-sm-12 col-md-6 col-lg-7">
                <div class="checkout-form">
                    <div class="section-title left-aligned">
                        <h3>Thông tin giao hàng</h3>
                    </div>

                        <div class="form-row mb-3">
                            <label for="name">Họ tên <span class="text-danger">*</span></label>
                            <input type="text" name="Name" class="form-control" id="first_name" value="{{ $user->Name }}" required>
                        </div>
                        <div class="form-row mb-3">
                            <div class="form-group col-12 col-sm-12 col-md-6">
                                <label for="email">Email <span class="text-danger">*</span></label>
                                <input type="text" name="Email" class="form-control" id="email_address" value="{{ $user->Email }}" required>
                            </div>
                            <div class="form-group col-12 col-sm-12 col-md-6">
                                <label for="phoneNumber">Điện thoại <span class="text-danger">*</span></label>
                                <input type="phone" name="PhoneNumber" class="form-control" id="tel_number" value="{{ $user->PhoneNumber }}" required>
                            </div>
                        </div>
                        <div class="form-row mb-3">
                            <div class="form-group col-12 col-sm-12 col-md-12">
                                <label for="address">Địa chỉ <span class="text-danger">*</span></label>
                                <input type="text" name="Address" class="form-control" id="p_address" value="{{ $user->Address }}" required>
                            </div>
                        </div>
                </div> <!-- end of checkout-form -->
            </div>
            <div class="col-12 col-sm-12 col-md-6 col-lg-5">
                <div class="order-summary">
                    <div class="section-title left-aligned">
                        <h3>Tóm tắt đơn hàng</h3>
                    </div>
                    <div class="product-container">
                        @foreach ($products as $item)
                            <div class="product-list">
                                <div class="product-inner media align-items-center">
                                    <div class="product-image mr-4 mr-sm-5 mr-md-4 mr-lg-5">
                                        <a href="{{ URL::asset($item->Product->Url) }}">
                                            <img src="{{ URL::asset($item->Product->Image) }}" alt="{{ $item->Product->ShortName }}" title="{{ $item->Product->ShortName }}">
                                        </a>
                                    </div>
                                    <div class="media-body">
                                        <h5>{{ $item->Product->ShortName }}</h5>
                                        <p class="product-quantity">Số lượng: {{ $item->Quantity }}</p>
                                        <p class="product-final-price">{{ number_format($item->Price, 0, '', ',')."vnđ"}}</p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div> <!-- end of product-container -->
                    <div class="order-review">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <tbody>
                                    <tr>
                                        <td><strong>Tổng tiền:</strong></td>
                                        <td><span class="color-primary">{{ number_format($total, 0, '', ',')."vnđ"}}</span></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="checkout-payment">
                        <div class="form-row justify-content-end">
                             <input type="submit" class="btn btn-primary dark btn-checkout" value="Hoàn tất đơn hàng">
                        </div>
                    </div> <!-- end of checkout-payment -->
                </div> <!-- end of order-summary -->
            </div>
        </div> <!-- end of row -->
    </div>
</div>
</form>
<script>
    function validateEmail(email) {
    return email.match(
        /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/
    );
};
function isVietnamesePhoneNumberValid(number) {
    return /(((\+|)84)|0)(3|5|7|8|9)+([0-9]{8})\b/.test(number);
}
$(document).on("click", ".btn-checkout", function (e) {
    var _token = $("input[name='_token']").val();
    var name = $('#first_name').val();
    var email = $('#email_address').val();
    var phone = $('#tel_number').val();
    var address = $('#p_address').val();
    if (name == '' || email == '' || phone == '' || address == '') {
        alert('Vui lòng nhập đầy đủ thông tin')
        e.preventDefault();
    }
    else {
        if (!validateEmail(email)) {
            alert('email sai định dạng')
            e.preventDefault();
        }
        else if (!isVietnamesePhoneNumberValid(phone)) {
            alert('số điện thoại không đúng')
            e.preventDefault();
        }
    }
});
</script>
@endsection