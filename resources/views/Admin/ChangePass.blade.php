@extends('shared.admin.layout')
@section('title', 'Đổi mật khẩu')
@section('content')
<h2>Thay đổi mật khẩu</h2>
<a class="btn quick-link" href="/admin/CreateAdmin"><i class="far fa-list mr-1"></i> Danh sách quản trị viên</a>
<div class="box_content px-300">
<form action="/admin/ChangePassword" method="post" id="ChangPasswordForm">        
    @csrf
    <table class="form_table">
        <tbody>
            <tr>
                <td class="form_name"><label for="OldPassword">Mật khẩu hiện tại</label></td>
                <td class="form_text">
                    <input class="form_control w300" id="OldPassword" name="OldPassword" type="password" />
                    @if ($errors->has('password')==true)
                        <label id="Password-error" class="error" for="Password">{{ $errors->first('password') }}</label>
                    @endif
                </td>
            </tr>
            <tr>
                <td class="form_name"><label for="Password">Mật khẩu mới</label></td>
                <td class="form_text">
                    <input class="form_control w300" id="Password" name="Password" type="password" />
                </td>
            </tr>
            <tr>
                <td class="form_name"><label for="ConfirmPassword">Nhập lại mật khẩu</label></td>
                <td class="form_text">
                    <input class="form_control w300" id="ConfirmPassword" name="ConfirmPassword" type="password" />
                </td>
            </tr>
            <tr>
                <td class="form_name"></td>
                <td class="form_text"><input class="btn quick-link" type="submit" value="Đổi mật khẩu"></td>
            </tr>
        </tbody>
    </table>
</form>
</div>
<script type="text/javascript">
jQuery.validator.addMethod("Equal", function(value, element, param) {
  return this.optional(element) || value == $(param).val();
}, "This has to be different...");
	$(document).ready(function() {
		$("#ChangPasswordForm").validate({
			rules: {
				OldPassword: {
                    required: true,
                    minlength: 6
                },
				Password:{
                    required: true,
                    minlength: 6
                },
                ConfirmPassword:{
                    required: true,
                    minlength: 6,
                    Equal: "#Password"
                }
			},
			messages: {
				OldPassword: {
					required: "Mật khẩu không được để trống",
                    minlength: "Mật khẩu phải từ 6 kí tự trở lên"
				},
				Password: {
					required: "Mật khẩu không được để trống",
					minlength: "Mật khẩu phải từ 6 kí tự trở lên"
				},
                ConfirmPassword: {
					required: "Mật khẩu không được để trống",
					minlength: "Mật khẩu phải từ 6 kí tự trở lên",
                    Equal:"Nhập lại mật khẩu không khớp"
				}
			}
		});
	});
	</script>
@endsection