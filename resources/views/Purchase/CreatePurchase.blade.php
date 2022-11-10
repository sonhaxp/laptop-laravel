@extends('shared.admin.layout')
@section('title', 'Danh sách phiếu nhập')
@section('content')
<style>
    img {
        background: #dcdcdc;
    }
</style>
<h2>Phiếu nhập</h2>
<a class="btn quick-link" href="/purchase/ListPurchase"><i class="fal fa-plus-circle mr-1"></i>Danh sách phiếu nhập</a>
<div class="box_content">
    <table class="form_table">
        <tr>
            <td class="form_name"><label for="typePurchase">Loại phiếu nhập</label></td>
            <td class="form_text">
                <select name="typePurchase" id="PurchaseId">
                    @foreach ($typePurchase as $item)
                    <option selected value="{{ $item->AttributeValueId }}">{{ $item->Value }}</option>
                    @endforeach
                </select>
            </td>
        </tr>
        <tr>
            <td class="form_name"><label for="Supplier">Nhà cung cấp</label></td>
            <td class="form_text">
                <select name="Supplier" id="SupplierId">
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
                <select name="Product" id="Product">
                    <option value="">Chọn sản phẩm</option>
                    @foreach ($product as $item)
                    <option value="{{ $item->ProductId }}">{{ $item->Name }}</option>
                    @endforeach
                </select>
            </td>
            <td class="form_name"><label for="PeriodOfGuarantee">Thời hạn bảo hành</label></td>
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
    <table id="trIMEI">

    </table>
    <h3 style="text-align: center;"><input type="submit" class="btn quick-link" id="btnAdd" value="Thêm mới" /></h3>
    <form action="/purchase/SubmitUpdatePurchase" method="post" id="Purchase">
        @csrf
    <table class="list_table tablecenter table-striped">
        <tbody>
            <tr id="renderProductDetail">
                <th>Mã hàng</th>
                <th>Tên hàng</th>
                <th>Số lượng</th>
                <th>Đơn giá</th>
                <th>Thành tiền</th>
                <th>IMEI/SN</th>
                <th>Hạn bảo hành</th>
            </tr>
            {{-- @foreach ($purchasedetail as $item)
                <tr data-id="{{ $item->PurchaseId }}">
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
    <h2><input type="submit" id="btnSubmit" class="btn quick-link" value="Lưu"></h2>
</form>
</div>
<script>
    var idproduct = 0;
    listProduct = new Map();
    $('#Product').on("change",function(){
        idproduct = this.value;
        if(this.value==""){
            $('#PeriodOfGuarantee').val('');
            $('#Quantity').val('');
            $('#Price').val('');
        }
        else
        $.ajax({
        url: "/GetInfoProduct?id=" + this.value,
        method: "GET",
        success: function (res) {
            res = JSON.parse(res);
            $('#PeriodOfGuarantee').val(res.PeriodOfGuarantee);
            $('#Quantity').val('');
            $('#Price').val(res.Price);
            $('#trIMEI').html('')
        },
        error: function () {
            console.log("Load api get thất bại");
        }
        });
    })

    $('#SupplierId').on("change",function(){
        if(this.value==""){
            $('#Deliver').val('');
            $('#PhoneNumber').val('');
            $('#Email').val('');
            $('#Address').val('');
            $('#trIMEI').html('')
        }
        else
        $.ajax({
        url: "/GetInfoSupplier?id=" + this.value,
        method: "GET",
        success: function (res) {
            res = JSON.parse(res);
            $('#Deliver').val(res.Name);
            $('#PhoneNumber').val(res.PhoneNumber);
            $('#Email').val(res.Email);
            $('#Address').val(res.Address);
        },
        error: function () {
            console.log("Load api get thất bại");
        }
        });
    })

    $('#Quantity').on("change",function(){
        if(idproduct == "" || idproduct==0){
            alert('Bạn phải nhập sản phẩm trước');
        }
        else
        if(isNaN(this.value)){
            alert('Số lượng phải là số');
        }
        else if(this.value<0){
            alert('Số lượng phải lớn hơn 0');
        }
        else{
            var html = "<tr><td class='form_text'><label for='IMEI'>IMEI</label></td>"
            for (let index = 0; index < this.value; index++) {
                html+="<td><input type='text' name='"+idproduct+"[]'' id='IMEI' value='' class='IMEI'><td>";
            }
            html+="</td>";
            $('#trIMEI').html(html)
        }

    })

    $('#btnAdd').on("click",function(){
        if($('#Quantity').val() == ""){
            alert('Vui lòng nhập sản phẩm và số lượng');
            return
        }
        if($('#Price').val()==""){
            alert('Giá không dc để trống');
            return
        }
        if(isNaN($('#Price').val())){
            alert('Giá phải là số');
            return
        }
        if($('#PeriodOfGuarantee').val()==""){
            alert('Giá không dc để trống');
            return
        }
        if(isNaN($('#PeriodOfGuarantee').val())){
            alert('Giá phải là số');
            return
        }
        var imei = new Set();
        var imeiArray = []
        for (let index = 0; index < $('.IMEI').length; index++) {
        if($('.IMEI').get(index).value==""||$('.IMEI').get(index).value.length<6){
            alert("IMEI không được để trống và phải từ 6 kí tự trở lên")
            return 1;
        }
        else{
            imei.add($('.IMEI').get(index).value);
            imeiArray.push($('.IMEI').get(index).value);
        }
        }
        if(imei.size!=$('.IMEI').length){
            alert("Đã có IMEI trùng nhau. Vui lòng kiểm tra lại");
            return
        }
        const ProductDetail = {ProductId:idproduct,ProductName:$('#Product  option:selected').text(),  Quantity: $('#Quantity').val()*1,PeriodOfGuarantee: $('#PeriodOfGuarantee').val()*1, Price: $('#Price').val()*1, IMEI : imeiArray};
        if(listProduct.get(ProductDetail.ProductId)==null){
            listProduct.set(ProductDetail.ProductId,ProductDetail)
        }
        else{
            let temp = listProduct.get(ProductDetail.ProductId);
            temp.Quantity += ProductDetail.Quantity*1;
            listProduct.set(ProductDetail.ProductId,temp);
        }
        html = ``;
        total = 0;
        for (const [key, value] of listProduct) {
            html+=` <tr class="deleleProductDetail" data-id="${key}">
                    <td>${key}</td>
                    <td>${value.ProductName}</td>
                    <td>${value.Quantity}</td>
                    <td>${value.Price}</td>
                    <td>${value.Quantity * value.Price}</td>
                    <td>${value.IMEI.toString()}</td>
                    <td>${value.PeriodOfGuarantee}th--
                        <a href="javascript:;" class="red-warring" onclick="deleteProductDetail(${key})">Xóa</a>
                    </td>
                </tr>`
            total+=value.Quantity * value.Price;
        }
        html+=` <tr class="deleleProductDetail" data-id="">
                    <td></td>
                    <td></td>
                    <td></td>
                    <td><div style="color:red;font-size:16px"><strong>Tổng</strong></div></td>
                    <td><div style="color:red;font-size:16px"><strong>${total}</strong><div></td>
                    <td></td>
                    <td></td>
                </tr>`
        $('.deleleProductDetail').remove();
        $('#renderProductDetail').after(html);
    });
    $('#btnSubmit').on("click",function(e){
        e.preventDefault();
        if($('#SupplierId').val() == ""){
            alert('Vui lòng chọn nhà cung cấp');
            return
        }
        if($('#Deliver').val() == ""){
            alert('Vui lòng nhập người giao');
            return
        }
        if($('#Address').val() == ""){
            alert('Vui lòng nhập địa chỉ NCC');
            return
        }
        if($('#PhoneNumber').val() == ""){
            alert('Vui lòng nhập SĐT');
            return
        }
        if($('#Email').val() == ""){
            alert('Vui lòng nhập Email');
            return
        }
        if(listProduct.size == 0){
            alert('Hóa đơn nhập phải có sản phẩm!!!');
            return
        }
        arrayProduct = []
        
        for (const [key, value] of listProduct) {
            arrayProduct.push(value);
        }
        const data = {
            _token: $('input[name="_token"]').get(0).value,
            PurchaseId: $('#PurchaseId').val(),
            SupplierId : $('#SupplierId').val(),
            Deliver : $('#Deliver').val(),
            Address : $('#Address').val(),
            PhoneNumber : $('#PhoneNumber').val(),
            Email : $('#Email').val(),
            Product : arrayProduct,
        }
        $.post('/purchase/SubmitCreatePurchase',data,function(res){
            if (res == 1) {
                alert("Thêm phiếu nhập thành công ");
                window.location='/purchase/ListPurchase';
            } else {
                alert("Thêm phiếu nhập không thành công");
            }
        })
    });

    function deleteProductDetail(id){
        listProduct.delete(`${id}`);
        html = ``;
        total = 0;
        for (const [key, value] of listProduct) {
            html+=` <tr class="deleleProductDetail" data-id="${key}">
                    <td>${key}</td>
                    <td>${value.ProductName}</td>
                    <td>${value.Quantity}</td>
                    <td>${value.Price}</td>
                    <td>${value.Quantity * value.Price}</td>
                    <td>${value.IMEI.toString()}</td>
                    <td>${value.PeriodOfGuarantee}th--
                        <a href="javascript:;" class="red-warring" onclick="delete(${key})">Xóa</a>
                    </td>
                </tr>`
            total+=value.Quantity * value.Price;
        }
        html+=` <tr class="deleleProductDetail" data-id="">
                    <td></td>
                    <td></td>
                    <td></td>
                    <td><div style="color:red;font-size:16px"><strong>Tổng</strong></div></td>
                    <td><div style="color:red;font-size:16px"><strong>${total}</strong><div></td>
                    <td></td>
                    <td></td>
                </tr>`
        $('.deleleProductDetail').remove();
        $('#renderProductDetail').after(html);
    }

     $("#Purchase").validate({
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