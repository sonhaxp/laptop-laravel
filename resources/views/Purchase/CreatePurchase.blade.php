@extends('shared.admin.layout')
@section('title', 'Danh sách phiếu nhập')
@section('content')
<style>
    img {
        background: #dcdcdc;
    }
</style>
<h2>Phiếu nhập</h2>
<a class="btn quick-link" href="/purchase/ListOrder"><i class="fal fa-plus-circle mr-1"></i>Danh sách phiếu nhập</a>
<div class="box_content">
    <table class="form_table">
        <tr>
            <td class="form_name"><label for="typePurchase">Loại phiếu nhập</label></td>
            <td class="form_text">
                <select name="typePurchase">
                    @foreach ($typePurchase as $item)
                    <option value="{{ $item->AttributeValueId }}">{{ $item->Value }}</option>
                    @endforeach
                </select>
            </td>
        </tr>
        <tr>
            <td class="form_name"><label for="Supplier">Nhà cung cấp</label></td>
            <td class="form_text">
                <select name="typePurchase">
                    <option value="">Chọn nhà cung cấp</option>
                    @foreach ($supplier as $item)
                    <option value="{{ $item->UserId }}">{{ $item->Name }}</option>
                    @endforeach
                </select>
            </td>
            <td class="form_name"><label for="Deliver">Người giao</label></td>
            <td class="form_text">
                <input type="text" name="Deliver" id="Deliver">
            </td>
        </tr>
        <tr>
            <td class="form_name"><label for="Address">Địa chỉ</label></td>
            <td class="form_text">
               <input type="text" name="Address" id="Address">
            </td>
            <td class="form_name"><label for="PhoneNumber">Số điện thoại</label></td>
            <td class="form_text">
                <input type="text" name="PhoneNumber" id="PhoneNumber">
            </td>
        </tr>
        <tr>
            <td class="form_name"><label for="Email">Email</label></td>
            <td class="form_text">
                <input type="text" name="Email" id="Email">
            </td>
            <td class="form_name"><label for="Employee">Người lập:</label></td>
            <td class="form_text">
                <div>{{ session('admin')->Name }}</div>
            </td>
        </tr>
        <tr>
            <td class="form_name"><label for="Product"><div style="font-size: 20px"><strong>Chi tiết phiếu nhập</strong></div></label></td>
        </tr>
    </table>
    <table>
        <tr>
            <td class="form_name"><label for="Product">Tên sản phẩm</label></td>
            <td class="form_text">
                <select name="Product">
                    <option value="">Chọn sản phẩm</option>
                    @foreach ($product as $item)
                    <option value="{{ $item->ProductId }}">{{ $item->Name }}</option>
                    @endforeach
                </select>
            </td>
            <td class="form_name"><label for="Name">Thời hạn bảo hành</label></td>
            <td class="form_text"><input class="form_control w300" id="PeriodOfGuarantee" name="PeriodOfGuarantee" type="text"  /></td>
        </tr>
        <tr>
            <td class="form_name"><label for="Price">Giá</label></td>
            <td class="form_text"><input class="form_control w300" id="Price" name="Price" type="text"  /></td>
            <td class="form_name"><label for="Quantity">Số lượng</label></td>
            <td class="form_text"><input class="form_control w300" id="Quantity" name="Quantity" type="text"  /></td>
            <td class="form_name"></td>
        </tr>
    </table>
    <h3 style="text-align: center;"><input type="submit" class="btn quick-link" value="Thêm mới" /></h3>
    <form action="/purchase/SubmitUpdateOrder" method="post" id="Order">
        @csrf
    <table class="list_table tablecenter table-striped">
        <tbody>
            <tr>
                <th>Mã hàng</th>
                <th>Tên hàng</th>
                <th>Số lượng</th>
                <th>Đơn giá</th>
                <th>Thành tiền</th>
                <th>IMEI/SN</th>
                <th>Hạn bảo hành</th>
            </tr>
            {{-- @foreach ($purchasedetail as $item)
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
            @endforeach --}}
        </tbody>
    </table>
    <h2><input type="submit" id="btn-submit" class="btn quick-link" value="Lưu"></h2>
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