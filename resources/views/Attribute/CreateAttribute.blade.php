@extends('shared.admin.layout')
@section('title', 'Tạo thuộc tính')
@section('content')
<h2>Thêm thuộc tính</h2>
<a class="btn quick-link" href="#list-attribute"><i class="far fa-list mr-1"></i> Danh sách thuộc tính</a>
<div class="box_content px-300">
    @if ($errors->has('success')==true)
    <div id="Username-error" class="success">{{ $errors->first('success') }}</div>
    @endif
    <form action="/attribute/SubmitAttribute" method="post" id="CreateAttributeForm">        
        @csrf
        <table class="form_table">
                <tbody>
                    <tr>
                        <td class="form_name"><label for="Name">Tên thuộc tính</label></td>
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
    <p>Có tổng số <strong>{{ $attribute->count() }}</strong> thuộc tính</p>
    <table class="list_table tablecenter table-striped" id="list-attribute">
        <tbody>
            <tr>
                <th style="width: 100px">Ngày tạo</th>
                <th style="width: 300px">Tên thuộc tính</th>
                <th>Hoạt động</th>
                <th style="width: 100px"></th>
            </tr>
            @foreach ($attribute as $item)
                <tr data-id="{{ $item->AttributeId }}">
                    <td>{{ $item->CreateAt }}</td>
                    <td>
                        {{ $item->Name }}
                    </td>
                    <td><input {{ $item->Status==1?"checked":"" }} class="check-box" disabled="disabled" type="checkbox" /></td>
                   
                    <td>
                        <a href="/attribute/UpdateAttribute/{{$item->AttributeId }}">Sửa</a>
                        - <a href="javascript:;" onclick="deleteAttribute('{{$item->AttributeId}}')" class="red-warring">Xóa</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
<script type="text/javascript">
    $("#CreateAttributeForm").validate({
			rules: {
				Name: {
                    required: true,
                }
			},
			messages: {
				Name: {
					required: "Tên thuộc tính không được để trống",
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