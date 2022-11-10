@extends('shared.admin.layout')
@section('title', 'Danh sách sản phẩm')
@section('content')
<style>
    img {
        background: #dcdcdc;
    }
</style>
<h2>Danh sách sản phẩm</h2>
<a class="btn quick-link" href="/product/CreateProduct"><i class="fal fa-plus-circle mr-1"></i>Thêm sản phẩm</a>
<div class="box_content">
    <form action="/product/ListProduct" method="get">
        @csrf
        <div class="row">
            <div class="col-lg-4">
                Danh mục
                <select name="catId">
                    <option value="">Tất cả danh mục</option>
                    @foreach ($category as $item)
                    <option value="{{ $item->CategoryId }}">{{ $item->Name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-lg-4">
                Từ khóa <input class="w300" id="Name" name="Name" type="text" />
            </div>
            <input class="w300" id="pageCurrent" name="pageCurrent" hidden type="text" value="1" />
            <div class="col-lg-4 align-self-center">
                <button type="submit" id="submit" class="btn-search">Tìm kiếm</button>
            </div>
        </div>
    </form>
    <p>Có tổng số <strong>{{ $count }}</strong> sản phẩm</p>
    <table class="list_table tablecenter table-striped">
        <tbody>
            <tr>
                <th style="width: 400px">Tên</th>
                <th style="width: 50px">Hình ảnh</th>
                <th>Danh mục</th>
                <th>Thương hiệu</th>
                <th>Số lượng</th>
                <th>Hoạt động</th>
                <th style="width: 100px"></th>
            </tr>
            @foreach ($product as $item)
                <tr data-id="{{ $item->ProductId }}">
                    <td>
                        {{ $item->ShortName}}
                    </td>
                    <td><img src="/{{ $item->Image }}" alt="" width="150"/></td>
                    <td>
                        {{ $item->Category->Name }}
                    </td>
                    <td>
                        {{ $item->Brand->Name }}
                    </td>
                    <td>
                        {{ $item->Quantity}}
                    </td>
                    <td><input {{ $item->Status==1?"checked":"" }} class="check-box" disabled="disabled" type="checkbox" /></td>
                    <td>
                        <a href="/product/UpdateProduct?productId={{$item->ProductId }}">Sửa</a>
                        - <a href="javascript:;" onclick="deleteProduct('{{$item->ProductId}}')" class="red-warring">Xóa</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@for ($i = 1; $i <= $page; $i++)
@if($pageCurrent==$i)
    <div class="btn btn-primary btn-paging filter" style="background: red;">{{ $i }}</div>
@else
    <div class="btn btn-primary btn-paging filter">{{ $i }}</div>              
@endif
@endfor
<form action="/product/DeleteProduct" method="post">
    @csrf
</form>
<script>
    $('.btn.btn-primary.btn-paging').on("click",function(){
        $('#pageCurrent').val($(this).html());
        $( "#submit" ).click();
    })

        function deleteProduct(id) {
            let _token = $('input[name="_token"]').get(1).value;
            if (confirm("Bạn có chắc chắn xóa sản phẩm này không?")) {
                $.post("/product/DeleteProduct", { product: id, _token:_token}, function (data) {
                    if (data) {
                        alert("Xóa sản phẩm thành công");
                        $("tr[data-id='" + id + "']").fadeOut();
                    } else {
                        alert("Sản phẩm đã phát sinh giao dịch. Không thể xóa");
                    }
                });
            }
    }
</script>
@endsection