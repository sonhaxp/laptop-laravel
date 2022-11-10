@extends('shared.admin.layout')
@section('title', 'Tạo quảng cáo')
@section('content')
<h2>Thêm quảng cáo</h2>
<a class="btn quick-link" href="#list-slider"><i class="far fa-list mr-1"></i> Danh sách quảng cáo</a>
<div class="box_content px-300">
    @if ($errors->has('success')==true)
    <div id="Username-error" class="success">{{ $errors->first('success') }}</div>
    @endif
    <form action="/admin/SubmitCreateBanner" method="post" id="CreateAttributeForm" enctype="multipart/form-data">        
        @csrf
        <table class="form_table">
                <tbody>
                    <tr>
                        <td class="form_name"><label for="BannerName">Tên quảng cáo</label></td>
                        <td class="form_text">
                            <input class="form_control w300" data-val="true"  id="BannerName" name="BannerName" type="text" value="" />
                        </td>
                    </tr>
                    <tr>
                        <td class="form_name"><label for="Slogan">Slogan</label></td>
                        <td class="form_text">
                            <input class="form_control w300" data-val="true"  id="Slogan" name="Slogan" type="text" value="" />
                        </td>
                    </tr>
                    <tr>
                        <td class="form_name"><label for="Image">Hình ảnh</label></td>
                        <td class="form_text"><input id="Image" name="Image" type="file" />
                        @if ($errors->has('image')==true)
                        <label id="image-error" class="error" for="image">{{ $errors->first('image') }}</label>
                        @endif
                        </td>
                    </tr>
                    <tr>
                        <td class="form_name"><label for="BtnText">Tên nút</label></td>
                        <td class="form_text">
                            <input class="form_control w300" id="BtnText" name="BtnText" type="text" />
                        </td>
                    </tr>
                    <tr>
                        <td class="form_name"><label for="URL">Đường dẫn</label></td>
                        <td class="form_text">
                            <input class="form_control w300" id="URL" name="URL" type="text" />
                        </td>
                    </tr>
                    <tr>
                        <td class="form_name"><label for="Sort">Sắp xếp</label></td>
                        <td class="form_text">
                            <input class="form_control w300" id="Sort" name="Sort" type="text" />
                        </td>
                    </tr>
                    <tr>
                        <td class="form_name"><label for="Status">Hoạt động</label></td>
                        <td class="form_text">
                            <input checked="checked" id="Status" name="Status" type="checkbox" value="1" />
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
    <p>Có tổng số <strong>{{ $slider->count() }}</strong> quảng cáo</p>
    <table class="list_table tablecenter table-striped" id="list-slider">
        <tbody>
            <tr>
                <th style="width: 100px">STT</th>
                <th style="width: 300px">Tên quảng cáo</th>
                <th>Hình ảnh</th>
                <th>Hoạt động</th>
                <th style="width: 100px"></th>
            </tr>
            @foreach ($slider as $item)
                <tr data-id="{{ $item->Id }}">
                    <td>{{ $item->Sort }}</td>
                    <td>
                        {{ $item->BannerName }}
                    </td>
                    <td><img src="/{{ $item->Image }}" alt="" width="150"/></td>
                    <td><input {{ $item->Status==1?"checked":"" }} class="check-box" disabled="disabled" type="checkbox" /></td>
                   
                    <td>
                        <a href="/slider/UpdateAttribute/{{$item->AttributeId }}">Sửa</a>
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
				BannerName: {
                    required: true,
                },
                Image:{
                    required:true
                },
                BtnText:{
                    required: true,
                },
                URL:{
                    required:true
                },
                Sort:{
                    required:true,
                    digits: true
                }
			},
			messages: {
				BannerName: {
					required: "Tên quảng cáo không được để trống",
				},
                BtnText:{
                    required: "Nút không được để trống",
                },
                URL: {
					required: "Đường dẫn không được để trống",
				},
                Image:{
                    required: "Ảnh không được để trống",
                },
                Sort:{
                    required: "Độ ưu tiên không được để trống",
					digits: "Độ ưu tiên phải là số"
                }
			}
		});
    //     function deleteArticleCategories(id) {
    //         let _token = $('input[name="_token"]').get(1).value;
    //         if (confirm("Bạn có chắc chắn xóa Danh mục bài viết này không?")) {
    //             $.post("/article/DeleteArticleCategories", { slider: id, _token:_token}, function (data) {
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