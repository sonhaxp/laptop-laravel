@extends('shared.admin.layout')
@section('title', 'Tạo giá trị thuộc tính')
@section('content')
<h2>Thêm giá trị thuộc tính</h2>
<a class="btn quick-link" href="#box_content"><i class="far fa-list mr-1"></i> Danh sách giá trị thuộc tính</a>
<div class="box_content px-300">
    @if ($errors->has('success')==true)
    <div id="Username-error" class="success">{{ $errors->first('success') }}</div>
    @endif
    <form action="/attribute/SubmitAttributeValue" method="post" id="CreateAttributeForm">        
        @csrf
        <table class="form_table">
                <tbody>
                    <tr>
                        <td class="form_name"><label for="Attribute">Thuộc tính</label></td>
                        <td class="form_text">
                            <select id="Attribute" name="Attribute" required>
                                <option selected="selected" value="">Chọn thuộc tính</option>
                                @foreach ($attribute as $item)
                                <option value="{{ $item->AttributeId }}">{{ $item->Name }}</option>     
                                @endforeach
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td class="form_name"><label for="Value">Giá trị</label></td>
                        <td class="form_text">
                            <input class="form_control w300" data-val="true"  id="Value" name="Value" type="text" value="" />
                            @if ($errors->has('Value')==true)
                            <label id="Value-error" class="error" for="Value">{{ $errors->first('Value') }}</label>
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
    <p>Có tổng số <strong>{{ $attribute->count() }}</strong> giá trị thuộc tính</p>
    <table class="list_table tablecenter table-striped">
        <tbody>
            <tr>
                <th style="width: 300px">Thuộc tính</th>
                <th style="width: 300px">Giá trị</th>
                <th>Hoạt động</th>
                <th style="width: 100px"></th>
            </tr>
            @foreach ($attributevalue as $item)
                <tr data-id="{{ $item->AttributeValueId }}">
                    <td>
                        {{ $item->attribute->Name }}
                    </td>
                    <td>
                        {{ $item->Value }}
                    </td>
                    <td><input {{ $item->Status==1?"checked":"" }} class="check-box" disabled="disabled" type="checkbox" /></td>
                   
                    <td>
                        <a href="/attribute/UpdateAttribute/{{$item->AttributeValueId }}">Sửa</a>
                        - <a href="javascript:;" onclick="deleteAttribute('{{$item->AttributeValueId}}')" class="red-warring">Xóa</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
<script type="text/javascript">
    $("#CreateAttributeForm").validate({
			rules: {
                Attribute:{
                    required: true,
                },
				Value: {
                    required: true,
                }
			},
			messages: {
				Attribute: {
					required: "Tên thuộc tính không được để trống",
				},
                Value: {
					required: "Tên giá trị thuộc tính không được để trống",
				}
			}
		});
    //     function deleteArticleCategories(id) {
    //         let _token = $('input[name="_token"]').get(1).value;
    //         if (confirm("Bạn có chắc chắn xóa Danh mục bài viết này không?")) {
    //             $.post("/article/DeleteArticleCategories", { attribute: id, _token:_token}, function (data) {
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