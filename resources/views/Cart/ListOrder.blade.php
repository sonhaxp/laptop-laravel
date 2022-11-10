@extends('shared.admin.layout')
@section('title', 'Danh sách đơn hàng')
@section('content')
<style>
    img {
        background: #dcdcdc;
    }
</style>
<h2>Danh sách đơn hàng</h2>
<a class="btn quick-link" href="/order/CreateOrder"><i class="fal fa-plus-circle mr-1"></i>Thêm đơn hàng</a>
<div class="box_content">
    <form action="/order/ListOrder" method="get">
        @csrf
        <div class="row">
            <div class="col-lg-4">
                Loại đơn hàng
                <select name="typeOrder">
                    <option value="">Tất cả đơn hàng</option>
                    @foreach ($typeOrder as $item)
                    <option value="{{ $item->AttributeValueId }}">{{ $item->Value }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-lg-4">
                Khách hàng <input class="w300" id="Name" name="Name" type="text" />
            </div>
            <input class="w300" id="pageCurrent" name="pageCurrent" hidden type="text" value="1" />
            <div class="col-lg-4 align-self-center">
                <button type="submit" id="submit" class="btn-search">Tìm kiếm</button>
            </div>
        </div>
    </form>
    <p>Có tổng số <strong>{{ $count }}</strong> đơn hàng</p>
    <table class="list_table tablecenter table-striped">
        <tbody>
            <tr>
                <th>Ngày</th>
                <th>Mã hóa đơn</th>
                <th>Giá trị</th>
                <th>Người nhận</th>
                <th>Số điện thoại</th>
                <th>Địa chỉ</th>
                <th>Email</th>
                <th>Trạng thái</th>
                <th>Thao tác</th>
            </tr>
            @foreach ($order as $item)
                <tr data-id="{{ $item->OrderId }}">
                    <td>{{ $item->CreateAt->format('d-m-Y') }}</td>
                    <td>{{ $item->OrderId }}</td>
                    <td>{{ number_format($item->TongTien, 0, '', ',')."vnđ" }}</td>
                    <td>{{ $item->Receiver }}</td>
                    <td>{{ $item->PhoneNumber }}</td>
                    <td>{{ $item->Address }}</td>
                    <td>{{ $item->Email }}</td>
                    <td>{{ $item->attributevalue->Value }}</td>
                    <td>
                        <a href="#" title="Xem chi tiết" data-target="#quickk_view" data-toggle="modal" name="{{ $item->OrderId }}" id="show-transaction">Xem</a>
                        @if ($item->Status==17)
                        <a href="/order/UpdateOrder?orderId={{$item->OrderId }}">Duyệt</a>
                        - <a href="javascript:;" onclick="deleteOrder('{{$item->OrderId}}')" class="red-warring">Hủy đơn</a>
                        @endif
                    </th>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
<div class="modal fade" id="quickk_view">
    <div class="container">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    
                </div>
            </div>
        </div>
    </div>
</div>

@for ($i = 1; $i <= $page; $i++)
@if($pageCurrent==$i)
    <div class="btn btn-primary btn-paging filter" style="background: red;">{{ $i }}</div>
@else
    <div class="btn btn-primary btn-paging filter">{{ $i }}</div>              
@endif
@endfor
<form action="/order/DeleteOrder" method="post">
    @csrf
</form>
<script>
    $('.btn.btn-primary.btn-paging').on("click",function(){
        $('#pageCurrent').val($(this).html());
        $( "#submit" ).click();
    })
        function deleteOrder(id) {
            let _token = $('input[name="_token"]').get(1).value;
            if (confirm("Bạn có chắc chắn hủy đơn hàng này không?")) {
                $.post("/order/DeleteOrder", { order: id, _token:_token}, function (data) {
                    if (data) {
                        alert("Hủy đơn hàng thành công");
                    } else {
                        alert("Đơn hàng đã phát sinh giao dịch. Không thể xóa");
                    }
                });
            }
    }
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