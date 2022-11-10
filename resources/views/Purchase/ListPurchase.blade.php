@extends('shared.admin.layout')
@section('title', 'Danh sách phiếu nhập')
@section('content')
<style>
    img {
        background: #dcdcdc;
    }
</style>
<h2>Danh sách phiếu nhập</h2>
<a class="btn quick-link" href="/purchase/CreatePurchase"><i class="fal fa-plus-circle mr-1"></i>Thêm phiếu nhập</a>
<div class="box_content">
    <form action="/purchase/ListPurchase" method="get">
        @csrf
        <div class="row">
            <div class="col-lg-4">
                Loại phiếu nhập
                <select name="typePurchase">
                    <option value="">Tất cả phiếu nhập</option>
                    @foreach ($typePurchase as $item)
                    <option value="{{ $item->AttributeValueId }}">{{ $item->Value }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-lg-4">
                Nhà cung cấp <input class="w300" id="Name" name="Name" type="text" />
            </div>
            <input class="w300" id="pageCurrent" name="pageCurrent" hidden type="text" value="1" />
            <div class="col-lg-4 align-self-center">
                <button type="submit" id="submit" class="btn-search">Tìm kiếm</button>
            </div>
        </div>
    </form>
    <p>Có tổng số <strong>{{ $count }}</strong> phiếu nhập</p>
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
            @foreach ($purchase as $item)
                <tr data-id="{{ $item->PurchaseId }}">
                    <td>{{ $item->CreateAt->format('d-m-Y') }}</td>
                    <td>{{ $item->PurchaseId }}</td>
                    <td>{{ number_format($item->TongTien, 0, '', ',')."vnđ" }}</td>
                    <td>{{ $item->Receiver }}</td>
                    <td>{{ $item->PhoneNumber }}</td>
                    <td>{{ $item->Address }}</td>
                    <td>{{ $item->Email }}</td>
                    <td>{{ $item->attributevalue->Value }}</td>
                    <td>
                        <a href="#" title="Xem chi tiết" data-target="#quickk_view" data-toggle="modal" name="{{ $item->PurchaseId }}" id="show-transaction">Xem</a>
                        @if ($item->Status==17)
                        <a href="/purchase/UpdatePurchase?purchaseId={{$item->PurchaseId }}">Duyệt</a>
                        - <a href="javascript:;" onclick="deletePurchase('{{$item->PurchaseId}}')" class="red-warring">Hủy đơn</a>
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
<form action="/purchase/DeletePurchase" method="post">
    @csrf
</form>
<script>
    $('.btn.btn-primary.btn-paging').on("click",function(){
        $('#pageCurrent').val($(this).html());
        $( "#submit" ).click();
    })
        function deletePurchase(id) {
            let _token = $('input[name="_token"]').get(1).value;
            if (confirm("Bạn có chắc chắn hủy phiếu nhập này không?")) {
                $.post("/purchase/DeletePurchase", { purchase: id, _token:_token}, function (data) {
                    if (data) {
                        alert("Hủy phiếu nhập thành công");
                    } else {
                        alert("phiếu nhập đã phát sinh giao dịch. Không thể xóa");
                    }
                });
            }
    }
    $(document).on("click", "#show-transaction", function () {
    var id = $(this).attr("name");
    $.ajax({
        url: "/GetPurchaseDetailAdmin/" + id,
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