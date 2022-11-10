@extends('shared.admin.layout')
@section('title', 'Quản lí danh mục bài viết')
@section('content')
<h2>Thêm Danh sách bài viết</h2>
<a class="btn quick-link" href="#list-admin"><i class="far fa-list mr-1"></i> Danh sách bài viết</a>
<div class="box_content px-300">
    @if ($errors->has('success')==true)
    <div id="Username-error" class="success">{{ $errors->first('success') }}</div>
    @endif
    <form action="/article/CreateCategoryArticle" method="post" id="CreateCategoryArticleForm">        
        @csrf
        <table class="form_table">
                <tbody>
                    <tr>
                        <td class="form_name"><label for="ParentCategory">Danh mục cha</label></td>
                        <td class="form_text">
                            <select id="ParentCategory" name="ParentCategory">
                                <option selected="selected" value="{{ 0 }}">Không có</option>
                                @foreach ($category as $item)
                                <option value="{{ $item->ArticleCategoriesId }}">{{ $item->CategoryName }}</option>     
                                @endforeach
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td class="form_name"><label for="CategoryName">Tên danh mục</label></td>
                        <td class="form_text">
                            <input class="form_control w300" data-val="true"  id="CategoryName" name="CategoryName" type="text" value="" />
                            @if ($errors->has('CategoryName')==true)
                            <label id="CategoryName-error" class="error" for="CategoryName">{{ $errors->first('CategoryName') }}</label>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td class="form_name"><label for="URL">Đường dẫn</label></td>
                        <td class="form_text">
                            <input class="form_control w300" id="URL" name="URL" type="text" />
                        </td>
                    </tr>
                    <tr>
                        <td class="form_name"><label for="CategorySort">Độ ưu tiên</label></td>
                        <td class="form_text">
                            <input class="form_control w300" id="CategorySort" name="CategorySort" type="text" />
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
<div class="box_content mt-5">
    <table class="list_table" id="list-admin">
        <tbody>
            <tr>
                <th>STT</th>
                <th>Danh mục cha</th>
                <th>Tên danh mục</th>
                <th>Đường dẫn</th>
                <th>Hoạt động</th>
                <th></th>
            </tr>
                @foreach ($category as $item)
                <tr data-id="{{ $item->ArticleCategoriesId }}">
                    <td class="left">{{ $item->CategorySort }}</td>
                    <td>{{ $item->articlecategory == null?"Không có":$item->articlecategory->CategoryName }}</td>
                    <td>{{ $item->CategoryName }}</td>
                    <td>{{ $item->Url }}</td>
                    <td><input class="check-box" {{ $item->Status==1?"checked":"" }} disabled="disabled" type="checkbox" /></td>
                    <td class="list-icon">
                        <a href="/article/EditArticleCategories/{{$item->ArticleCategoriesId }}">Sửa</a> - <a href="javascript:;" class="red-warring" onclick="deleteArticleCategories({{$item->ArticleCategoriesId}})">Xóa</a>
                    </td>
                </tr>
                @endforeach
        </tbody>
    </table>
</div>
<form action="/article/DeleteArticleCategories" method="POST">
    @csrf
</form>
<script type="text/javascript">
    $("#CreateCategoryArticleForm").validate({
			rules: {
				CategoryName: {
                    required: true,
                    minlength: 6
                },
                URL: {
                    required: true,
                    minlength: 6
                },
				CategorySort:{
                    required: true,
                    digits: true
                }
			},
			messages: {
				CategoryName: {
					required: "Tên không được để trống",
                    minlength: "Tên khoản phải từ 6 kí tự trở lên"
				},
				URL: {
					required: "Đường dẫn không được để trống",
					minlength: "Đường dẫn phải từ 6 kí tự trở lên"
				},
                CategorySort: {
					required: "Độ ưu tiên không được để trống",
					digits: "Độ ưu tiên phải là số"
				}
			}
		});
        function deleteArticleCategories(id) {
            let _token = $('input[name="_token"]').get(1).value;
            if (confirm("Bạn có chắc chắn xóa Danh mục bài viết này không?")) {
                $.post("/article/DeleteArticleCategories", { category: id, _token:_token}, function (data) {
                    if (data) {
                        alert("Xóa Danh mục bài viết viên thành công");
                        $("tr[data-id='" + id + "']").fadeOut();
                    } else {
                        alert("Không tồn tại Danh mục bài viết viên này");
                    }
                });
            }
    }
</script>
@endsection