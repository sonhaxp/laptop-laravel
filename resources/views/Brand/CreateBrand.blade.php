@extends('shared.admin.layout')
@section('title', 'Tạo thương hiệu')
@section('content')
<h2>Thêm thương hiệu</h2>
<a class="btn quick-link" href="#list-attribute"><i class="far fa-list mr-1"></i> Danh sách thương hiệu</a>
<div class="box_content px-300">
    @if ($errors->has('success')==true)
    <div id="Username-error" class="success">{{ $errors->first('success') }}</div>
    @endif
    <form action="/brand/SubmitBrand" method="post" id="CreateBrandForm">        
        @csrf
        <table class="form_table">
                <tbody>
                    <tr>
                        <td class="form_name"><label for="ParentBrand">Thương hiệu cha</label></td>
                        <td class="form_text">
                            <select id="ParentBrand" name="ParentBrand">
                                <option selected="selected" value="{{ 0 }}">Không có</option>
                                @foreach ($brand as $item)
                                <option value="{{ $item->BrandId }}">{{ $item->Name }}</option>     
                                @endforeach
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td class="form_name"><label for="Name">Tên thương hiệu</label></td>
                        <td class="form_text">
                            <input class="form_control w300" data-val="true"  id="Name" name="Name" type="text" value="" />
                            @if ($errors->has('Name')==true)
                            <label id="Name-error" class="error" for="Name">{{ $errors->first('Name') }}</label>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td class="form_name"><label for="Active">Hoạt động</label></td>
                        <td class="form_text">
                            <input checked="checked" id="Active" name="Active" type="checkbox" value="1" />
                        </td>
                    </tr>
                    <tr>
                        <td class="form_name"></td>
                        <td class="form_text">
                            <input type="submit" class="btn quick-link" value="Thêm mới">
                        </td>
                    </tr>
                </tbody>
            </table>
    </form>
</div>
<div class="box_content">
    <p>Có tổng số <strong>{{ $brand->count() }}</strong> thương hiệu</p>
    <table class="list_table tablecenter table-striped" id="list-attribute">
        <tbody>
            <tr>
                <th style="width: 100px">Ngày tạo</th>
                <th style="width: 300px">Tên thương hiệu</th>
                <th>Thương hiệu cha</th>
                <th>Hoạt động</th>
                <th style="width: 100px"></th>
            </tr>
            @foreach ($brand as $item)
                <tr data-id="{{ $item->BrandId }}">
                    <td>{{ $item->CreateAt }}</td>
                    <td>
                        {{ $item->Name }}
                    </td>
                    <td>{{ $item->brand==null?"Không có":$item->brand->Name }}</td>
                    <td><input {{ $item->Status==1?"checked":"" }} class="check-box" disabled="disabled" type="checkbox" /></td>
                   
                    <td>
                        <a href="/brand/UpdateBrand/{{$item->BrandId }}">Sửa</a>
                        - <a href="javascript:;" onclick="deleteBrand('{{$item->BrandId}}')" class="red-warring">Xóa</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
<script type="text/javascript">
    $("#CreateBrandForm").validate({
			rules: {
				Name: {
                    required: true,
                }
			},
			messages: {
				Name: {
					required: "Tên thương hiệu không được để trống",
				}
			}
		});
    //     function deleteArticleCategories(id) {
    //         let _token = $('input[name="_token"]').get(1).value;
    //         if (confirm("Bạn có chắc chắn xóa Danh mục bài viết này không?")) {
    //             $.post("/article/DeleteArticleCategories", { brand: id, _token:_token}, function (data) {
    //                 if (data) {
    //                     alert("Xóa Danh mục bài viết viên thành công");
    //                     $("tr[data-id='" + id + "']").fadeOut();
    //                 } else {
    //                     alert("Không tồn tại Danh mục bài viết viên này");
    //                 }
    //             });
    //         }
    // }
</script>
@endsection