@extends('shared.admin.layout')
@section('title', 'Quản lí admin')
@section('content')
<h2>Thêm Quản trị</h2>
<a class="btn quick-link" href="#list-admin"><i class="far fa-list mr-1"></i> Danh sách quản trị viên</a>
<div class="box_content px-300">
    @if ($errors->has('success')==true)
    <div id="Username-error" class="success">{{ $errors->first('success') }}</div>
    @endif
<form action="/admin/CreateAdmin" method="post" id="CreateAdminForm">        
    @csrf
    <table class="form_table">
            <tbody>
                <tr>
                    <td class="form_name"><label for="Role">Ph&#226;n quyền</label></td>
                    <td class="form_text">
                        <select data-val="true" data-val-required="The Phân quyền field is required." id="Role" name="Role">
                            <option selected="selected" value="{{ $role[0]->AttributeValueId }}">{{ $role[0]->Value }}</option>
                            <option value="{{ $role[1]->AttributeValueId }}">{{ $role[1]->Value }}</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td class="form_name"><label for="Username">T&#234;n đăng nhập</label></td>
                    <td class="form_text">
                        <input class="form_control w300" data-val="true"  id="Username" name="Username" type="text" value="" />
                        @if ($errors->has('username')==true)
                        <label id="Username-error" class="error" for="Username">{{ $errors->first('username') }}</label>
                        @endif
                    </td>
                </tr>
                <tr>
                    <td class="form_name"><label for="name">Họ tên</label></td>
                    <td class="form_text">
                        <input class="form_control w300" data-val="true"  id="name" name="name" type="text" value="" />
                    </td>
                </tr>
                <tr>
                    <td class="form_name"><label for="Password">Mật khẩu</label></td>
                    <td class="form_text">
                        <input class="form_control w300" data-val="true" data-val-length="Tối đa 60 ký tự" data-val-length-max="60" data-val-required="Hãy nhập mật khẩu" id="Password" name="Password" type="password" />
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
</form></div>
<div class="box_content mt-5">
    <table class="list_table" id="list-admin">
        <tbody>
            <tr>
                <th>T&#234;n đăng nhập</th>
                <th>Ph&#226;n quyền</th>
                <th>Hoạt động</th>
                <th></th>
            </tr>
                @foreach ($admins as $item)
                <tr data-id="admin">
                    <td class="left">{{ $item->UserName }}</td>
                    <td>{{ $item->Attributevalue->Value }}</td>
                    <td><input class="check-box" {{ $item->Status==1?"checked":"" }} disabled="disabled" type="checkbox" /></td>
                    <td class="list-icon">
                        <a href="/Admin/EditAdmin/{{$item->UserId }}">Sửa</a> - <a href="javascript:;" class="red-warring" onclick="deleteAdmins({{$item->UserId}})">Xóa</a>
                    </td>
                </tr>
                @endforeach
        </tbody>
    </table>
</div>
<form action="admin/DeleteAdmin" method="POST">
    @csrf
</form>
<script type="text/javascript">
    $("#CreateAdminForm").validate({
			rules: {
				Username: {
                    required: true,
                    minlength: 6
                },
                Name: {
                    required: true,
                    minlength: 6
                },
				Password:{
                    required: true,
                    minlength: 6
                }
			},
			messages: {
				Username: {
					required: "Tài khoản không được để trống",
                    minlength: "Tài khoản phải từ 6 kí tự trở lên"
				},
				Password: {
					required: "Mật khẩu không được để trống",
					minlength: "Mật khẩu phải từ 6 kí tự trở lên"
				}
			}
		});
        function deleteAdmins(id) {
            let _token = $('input[name="_token"]').get(1).value;
            if (confirm("Bạn có chắc chắn xóa quản trị này không?")) {
                $.post("/admin/DeleteAdmin", { username: id, _token:_token}, function (data) {
                    if (data) {
                        alert("Xóa quản trị viên thành công");
                        $("tr[data-id='" + id + "']").fadeOut();
                    } else {
                        alert("Không tồn tại quản trị viên này");
                    }
                });
            }
    }
</script>
@endsection