@extends('shared.admin.layout')
@section('title', 'Thêm nhà cung cấp')
@section('content')
<h2>Thêm mới nhà cung cấp</h2>
<a class="btn quick-link" href="/user/ListCustomer"><i class="far fa-list mr-1"></i> Danh sách nhà cung cấp</a>
<div class="box_content px-300" >
    @if ($errors->has('success')==true)
    <div id="Username-error" class="success">{{ $errors->first('success') }}</div>
    @endif
<form action="/user/CreateUser" id="CreateUser" enctype="multipart/form-data" method="post">        
    @csrf
    <table class="form_table">
            <tr>
                <td class="form_name"><label for="Name">Tên nhà cung cấp</label></td>
                <td class="form_text"><input class="form_control w300" id="Name" name="Name" type="text"  /></td>
                @if ($errors->has('User')==true)
                            <label id="User-error" class="error" for="User">{{ $errors->first('User') }}</label>
                            @endif
            </tr>
            <tr>
                <td class="form_name"><label for="Email">Email</label></td>
                <td class="form_text"><input class="form_control w300" id="Email" name="Email" type="text"  /></td>
            </tr>
            <tr>
                <td class="form_name"><label for="Address">Địa chỉ</label></td>
                <td class="form_text"><input class="form_control w300" id="Address" name="Address" type="text"  /></td>
            </tr>
            <tr>
                <td class="form_name"><label for="PhoneNumber">Điện thoại</label></td>
                <td class="form_text"><input class="form_control w300" id="PhoneNumber" name="PhoneNumber" type="text"  /></td>
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
    $("#CreateUser").validate({
			rules: {
				Name: {
                    required: true,
                    minlength: 6
                },
                Email: {
                    required: true,
                    minlength: 6,
                    regex: /^\b[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,4}\b$/i
                },
                Address: {
                    required: true,
                    minlength: 6
                },
                PhoneNumber: {
                    required: true,
                    minlength: 8,
                    maxLength: 11,
                    number: true
                },
			},
			messages: {
				Name: {
					required: "Tên không được để trống",
                    minlength: "Tên phải từ 6 kí tự trở lên"
				},
				Email: {
					required: "Email không được để trống",
					minlength: "Email phải từ 6 kí tự trở lên",
                    regex: "Không đúng định dạng email",
				},
                Address: {
					required: "Địa chỉ không được để trống",
					minlength: "Địa chỉ phải từ 6 kí tự trở lên"
				},
                PhoneNumber: {
					required: "Điện thoại không được để trống",
					minlength: "Số điện thoại phải từ 8 kí tự trở lên",
					maxlength: "Số điện thoại phải từ 11 kí tự trở xuống",
                    number: "Số điện thoại không đúng"
				}
			}
		});
</script>
@endsection