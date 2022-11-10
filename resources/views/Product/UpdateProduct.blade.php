@extends('shared.admin.layout')
@section('title', 'Sửa sản phẩm')
@section('content')
<h2>Sửa sản phẩm</h2>
<a class="btn quick-link" href="/product/ListProduct"><i class="far fa-list mr-1"></i> Danh sách sản phẩm</a>
<div class="box_content">
    @if ($errors->has('success')==true)
    <div id="Username-error" class="success">{{ $errors->first('success') }}</div>
    @endif
<form action="/product/SubmitUpdateProduct" id="CreateArticle" enctype="multipart/form-data" method="post">        
    @csrf
    <input type="text" class="btn quick-link" hidden name="ProductId"  id="ProductId" value="{{ $product->ProductId }}" />
    <table class="form_table">
            <tr>
                <td class="form_name"><label for="Category">Danh mục sản phẩm</label></td>
                <td class="form_text">
                    <select id="Category" name="Category">
                        <option value="">Chọn danh mục sản phẩm</option>
                        @foreach ($category as $item)
                        <option {{ $item->CategoryId == $product->CategoryId?"selected":"" }} value="{{ $item->CategoryId }}">{{ $item->Name }}</option>     
                        @endforeach
                    </select>
                </td>
                <td class="form_name">Số lượng</td>
                <td class="form_text">{{ $item->Quantity }}</td>
            </tr>
            <tr>
                <td class="form_name"><label for="Name">Tên sản phẩm</label></td>
                <td class="form_text"><input class="form_control w300" id="Name" name="Name" type="text" value="{{ $product->Name }}"  /></td>
                <td class="form_name"><label for="Name">Thời hạn bảo hành</label></td>
                <td class="form_text"><input class="form_control w300" id="PeriodOfGuarantee" name="PeriodOfGuarantee" type="text" value={{ $product->PeriodOfGuarantee }}  /></td>
            </tr>
            <tr>
                <td class="form_name"><label for="ShortName">Tên ngắn</label></td>
                <td class="form_text"><input class="form_control w300" id="ShortName" name="ShortName" type="text" value="{{ $product->ShortName }}" /></td>
                <td class="form_name"><label for="Brand">Thương hiệu</label></td>
                <td class="form_text">
                    <select id="Brand" name="Brand">
                        <option value="">Chọn thương hiệu</option>
                        @foreach ($brand as $item)
                        <option {{ $item->BrandId == $product->BrandId?"selected":"" }} value="{{ $item->BrandId }}">{{ $item->brand->Name }}</option>     
                        @endforeach
                    </select>
                </td>
            </tr>
            <tr>
                <td class="form_name"><label for="Price">Giá</label></td>
                <td class="form_text"><input class="form_control w300" id="Price" name="Price" type="text" value="{{ $product->Price }}" /></td>
                <td class="form_name"><label for="Discount">Giảm giá</label></td>
                <td class="form_text"><input class="form_control w300" id="Discount" name="Discount" type="text" value="{{ $product->Discount }}" /></td>
            </tr>
            <tr>
                <td class="form_name"><label for="Image">Hình ảnh</label></td>
                <td class="form_text">
                    <img src="{{ URL::asset($product->Image) }}" width="150px" alt="">
                    <input id="Image" name="Image" type="file"/>
                    @if ($errors->has('image')==true)
                        <label id="image-error" class="error" for="image">{{ $errors->first('image') }}</label>
                    @endif
                </td>
            </tr>
            <tr>
                <td class="form_name"><label for="Description">Mô tả</label></td>
                <td class="form_text"><input class="form_control w300" id="Description" name="Description" type="textarea"  value="{{ $product->Description }}"/></td>
            </tr>
            <tr>
                <td class="form_name"><label for="Url">Đường dẫn</label></td>
                <td class="form_text"><input class="form_control w300" id="Url" name="Url" type="text" value="{{ $product->Url }}"/></td>
            </tr>
            <tr id="listAttribute">
                <td class="form_name"><label for="Active">Hoạt động</label></td>
                <td class="form_text">
                    <input {{ $product->Status==1?"checked":"" }}  id="Active" name="Active" type="checkbox" value="1" />
                </td>
            </tr>
            @for ($i = 0; $i < $attribute->count(); $i+=2)
            <tr class="attribute_remove">
                <td class="form_name"><label for="{{ $attribute[$i]->attribute->Name }}">{{ $attribute[$i]->attribute->Name }}</label></td>
                <td class="form_text">
                    <select id="{{ $attribute[$i]->attribute->AttributeId }}" name="{{ $attribute[$i]->attribute->AttributeId }}">
                        <option selected="selected" value="">Chọn giá trị</option>
                        @foreach ($attribute[$i]->Value as $temp)
                        <option  {{$temp->flag == true?"selected":"" }} value="{{ $temp->AttributeValueId }}">{{ $temp->Value }}</option>  
                        @endforeach
                    </select>
                </td>
                @if ($i+1!=$attribute->count())
                <td class="form_name"><label for="{{ $attribute[$i+1]->attribute->Name }}">{{ $attribute[$i+1]->attribute->Name }}</label></td>
                <td class="form_text">
                    <select id="{{ $attribute[$i+1]->attribute->AttributeId }}" name="{{ $attribute[$i+1]->attribute->AttributeId }}">
                        <option selected="selected" value="">Chọn giá trị</option>
                        @foreach ($attribute[$i+1]->Value as $temp)
                        <option  {{$temp->flag == true?"selected":"" }} value="{{ $temp->AttributeValueId }}">{{ $temp->Value }}</option>  
                        @endforeach
                    </select>
                </td>
                @endif
            </tr>
            @endfor
            <tr>
                <td class="form_name"></td>
                <td class="form_text">
                    <input type="submit" class="btn quick-link" value="Cập nhật" />
                </td>
            </tr>
        </table>
</form>
</div>

<script type="text/javascript">
    $('#Category').on('change', function() {
        $('.attribute_remove').remove();
        $('#Brand').html("");
        if(this.value!=""){
            $.get("/product/attribute/"+this.value, function (data) {
                if (data) {
                    $("#listAttribute").after(data);
                }
            });
            $.get("/product/brandcategory/"+this.value, function (data) {
                if (data) {
                    $("#Brand").html(data);
                }
            });
        }
    });
    $("#CreateArticle").validate({
			rules: {
                Category:{
                    required: true,
                },
				Name: {
                    required: true,
                    minlength: 6
                },
                ShortName: {
                    required: true,
                    minlength: 6
                },
                Brand: {
                    required: true
                },
                Price: {
                    required: true,
                    number: true,
                },
                Discount: {
                    required: true,
                    number: true,
                },
                Description: {
                    required: true,
                    minlength: 6
                },
                Url: {
                    required: true,
                    minlength: 6
                },
                PeriodOfGuarantee: {
                    required: true,
                    number:true
                }
			},
			messages: {
                Category:{
                    required: "Danh mục không được để trống",
                },
				Name: {
					required: "Tên không được để trống",
                    minlength: "Tên khoản phải từ 6 kí tự trở lên"
				},
                ShortName: {
					required: "Tên ngắn không được để trống",
                    minlength: "Tên ngắn phải từ 6 kí tự trở lên"
				},
                Brand: {
					required: "Thương hiệu không được để trống",
				},
                Price: {
					required: "Giá không được để trống",
                    number: "Giá phải là số"
				},
                Discount: {
					required: "Giảm giá không được để trống",
                    minlength: "Giảm giá phải là số"
				},
                Description: {
                    required: "Mô tả không được để trống",
                    minlength: "Mô tả phải từ 6 kí tự trở lên"
                },
				Url: {
					required: "Đường dẫn không được để trống",
					minlength: "Đường dẫn phải từ 6 kí tự trở lên"
				},
			}
		});
</script>
@endsection