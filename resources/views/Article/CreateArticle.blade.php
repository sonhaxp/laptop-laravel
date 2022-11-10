@extends('shared.admin.layout')
@section('title', 'Thêm bài viết')
@section('content')
<h2>Thêm mới tin tức</h2>
<a class="btn quick-link" href="/article/ListArticle"><i class="far fa-list mr-1"></i> Danh sách bài viết</a>
<div class="box_content">
    @if ($errors->has('success')==true)
    <div id="Username-error" class="success">{{ $errors->first('success') }}</div>
    @endif
<form action="/article/CreateArticle" id="CreateArticle" enctype="multipart/form-data" method="post">        
    @csrf
    <table class="form_table">
            <tr>
                <td class="form_name"><label for="ArticleCategoryId">Danh mục bài viết</label></td>
                <td class="form_text">
                    <select id="ArticleCategoryId" name="ArticleCategoryId">
                        <option selected="selected" value="">Chon danh mục bài viết</option>
                        @foreach ($category as $item)
                        <option value="{{ $item->ArticleCategoriesId }}">{{ $item->CategoryName }}</option>     
                        @endforeach
                    </select>
                </td>
            </tr>
            <tr>
                <td class="form_name"><label for="Subject">Tiêu đề</label></td>
                <td class="form_text"><input class="form_control w300" id="Subject" name="Subject" type="text"  /></td>
            </tr>
            <tr>
                <td class="form_name"><label for="Image">Hình ảnh đại diện</label></td>
                <td class="form_text">
                    <input id="Image" name="Image" type="file"/>
                    @if ($errors->has('image')==true)
                        <label id="image-error" class="error" for="image">{{ $errors->first('image') }}</label>
                    @endif
                </td>
            </tr>
            <tr>
                <td class="form_name"><label for="Description">Trích dẫn ngắn</label></td>
                <td class="form_text">
                    <textarea class="text-box multi-line"  id="Description" name="Description"></textarea>
                    
                </td>
            </tr>
            <tr>
                <td class="form_name"><label for="Body">Nội dung</label></td>
                <td class="form_text"><textarea class="ckeditor" cols="20" id="Body" name="Body" rows="2"></textarea></td>
            </tr>
            <tr>
                <td class="form_name"><label for="URL">Đường dẫn</label></td>
                <td class="form_text">
                    <input class="form_control w300" id="URL" name="URL" type="text" />
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
                    <input type="submit" class="btn quick-link" value="Thêm mới" />
                </td>
            </tr>
        </table>
</form>
</div>

<script type="text/javascript">
    $("#CreateArticle").validate({
			rules: {
                ArticleCategoryId:{
                    required: true,
                },
				Subject: {
                    required: true,
                    minlength: 6
                },
                URL: {
                    required: true,
                    minlength: 6
                },
                Description: {
                    required: true,
                    minlength: 6
                },
                Body: {
                    required: true,
                    minlength: 6
                },
			},
			messages: {
                ArticleCategoryId:{
                    required: "Danh mục không được để trống",
                },
				Subject: {
					required: "Tên không được để trống",
                    minlength: "Tên khoản phải từ 6 kí tự trở lên"
				},
				URL: {
					required: "Đường dẫn không được để trống",
					minlength: "Đường dẫn phải từ 6 kí tự trở lên"
				},
                Description: {
					required: "Đường dẫn không được để trống",
					minlength: "Đường dẫn phải từ 6 kí tự trở lên"
				},
                Body: {
					required: "Đường dẫn không được để trống",
					minlength: "Đường dẫn phải từ 6 kí tự trở lên"
				}
			}
		});
</script>
@endsection