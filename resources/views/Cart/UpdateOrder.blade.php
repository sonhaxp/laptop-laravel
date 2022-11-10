@extends('shared.admin.layout')
@section('title', 'Danh sách đơn hàng')
@section('content')
<style>
    img {
        background: #dcdcdc;
    }
</style>
<h2>Hóa đơn</h2>
<a class="btn quick-link" href="/order/ListOrder"><i class="fal fa-plus-circle mr-1"></i>Danh sách đơn hàng</a>
<div class="box_content">
    <form action="/order/SubmitUpdateOrder" method="post" id="Order">
        @csrf
        <input type="text" hidden name="OrderId" value="{{ $order->OrderId }}">
    <table class="list_table tablecenter table-striped">
        <tbody>
            <tr>
                <th>Mã hàng</th>
                <th>Tên hàng</th>
                <th>Số lượng</th>
                <th>Đơn giá</th>
                <th>Khuyến mãi</th>
                <th>Thành tiền</th>
                <th>IMEI/SN</th>
                <th>Hạn bảo hành</th>
                <th>Sl trong kho</th>
            </tr>
            @foreach ($orderdetail as $item)
                <tr data-id="{{ $item->OrderId }}">
                    <td>{{ $item->ProductId}}</td>
                    <td>{{ $item->Product->Name }}</td>
                    <td>{{ $item->Quantity}}</td>
                    <td>{{ $item->Price }}</td>
                    <td>{{ $item->Discount }}</td>
                    <td>{{ $item->Price*$item->Quantity*(1-$item->Discount/100) }}</td>
                    <td>
                        <div>
                            @for ($i = 0; $i < $item->Quantity; $i++)
                            <input type="text" name="{{ $item->ProductId }}[]" id="IMEI" value="" class="IMEI">
                            @endfor
                        </div>
                    </td>
                    <td>
                        <div>
                            <div  class="HBH">{{ $item->Product->PeriodOfGuarantee }}th</div>
                        </div>
                    </td>
                    <td>
                        <div>
                            <div  class="sl">{{ $item->Product->Quantity }}</div>
                        </div>
                    </td>
                </tr>
            @endforeach
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td>Tổng</td>
                <td>{{ $orderdetail->Sum(function ($item) {
                    return $item->Price*$item->Quantity*(1-$item->Discount/100);
                    }); }}</td>
                <td>
                </td>
                <td>
                </td>
                <td>
                </td>
            </tr>
        </tbody>
    </table>
    <h2><input type="submit" id="btn-submit" class="btn quick-link" value="Duyệt"></h2>
</form>
</div>
<script>
    $('#btn-submit').on("click",function(e){
        var list_imei = $('.IMEI');
        for (let index = 0; index < list_imei.length; index++) {
            const element = list_imei[index];
            if(element.value.length<6){
                alert('IMEI không được để trống và phải từ 6 kí tự trở lên');
                e.preventDefault();
                return
            }
        }
    })
     $("#Order").validate({
			rules: {
				IMEI: {
                    required: true,
                    minlength: 6
                }
			},
			messages: {
				IMEI: {
					required: "IMEI không được để trống",
                    minlength: "IMEI phải từ 6 kí tự trở lên"
				},
			}
		});
    $(document).on("click", "#show-transaction", function () {
    var id = $(this).attr("name");
    $.ajax({
        url: "/GetOrderDetailAdmin/" + id,
        method: "GET",
        success: function (res) {
            $(".modal-body").html(res);
        },
        error: function () {
            console.log("Load api get thất bại");
        }
    });
});
</script>
@endsection