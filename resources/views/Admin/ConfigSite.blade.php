@extends('shared.admin.layout')
@section('title', 'Thông tin chung')
@section('content')
<style>
    .form_name {
        width: 135px;
    }
</style>
<h2>Cập nhật thông tin chung website</h2>
<a class="btn quick-link" href="/admin"><i class="far fa-list mr-1"></i> Quay lại trang chủ</a>
<div class="box_content">
    @if ($errors->has('success')==true)
    <div id="Username-error" class="success">{{ $errors->first('success') }}</div>
    @endif
    <form action="/admin/UpdateConfigSite" enctype="multipart/form-data" method="post" id="updateConfig"><input data-val="true" data-val-number="The field Id must be a number." data-val-required="The Id field is required." id="Id" name="Id" type="hidden" value="1" />        <table class="form_table">
        @csrf
        <tr>
            <td class="form_name"><label for="Title">Tên</label></td>
            <td class="form_text"><input class="form_control w300" data-val="true" data-val-length="Tối đa 200 ký tự" data-val-length-max="200" id="Name" name="Name" type="text" value="{{ $configSite->Name }}" /></td>
        </tr>    
        <tr>
                <td class="form_name"><label for="Title">Tiêu đề</label></td>
                <td class="form_text"><input class="form_control w300" data-val="true" data-val-length="Tối đa 200 ký tự" data-val-length-max="200" id="Title" name="Title" type="text" value="{{ $configSite->Title }}" /></td>
            </tr>
            <tr>
                <td class="form_name"><label for="Description">Thẻ description</label></td>
                <td class="form_text">
                    <textarea class="multi-line" cols="20" data-val="true" data-val-length="Tối đa 500 ký tự" data-val-length-max="500" id="Description" name="Description" rows="6">{{ $configSite->Description }}</textarea>
                </td>
            </tr>
            <tr>
                <td class="form_name"><label for="Image">Logo</label></td>
                <td class="form_text"><input id="Image" name="Image" type="file" value="{{ $configSite->Image }}" /> <span class="red-warring">Kích thươc: 160px - 62px</span></td>
            </tr>
                <tr>
                    <td class="form_name"></td>
                    <td class="form_text"><img class="img-border" src="{{URL::asset($configSite->Image) }}" /></td>
                </tr>
            <tr>
                <td class="form_name"><label for="Place">Địa chỉ</label></td>
                <td class="form_text"><input class="form_control w300" id="Place" name="Place" type="text" value="{{ $configSite->Place }}" />
</td>
            </tr>
            {{-- <tr>
                <td class="form_name"><label for="VPDD">VPDD</label></td>
                <td class="form_text"><input class="form_control w300" id="VPDD" name="VPDD" type="text" value="{{$configSite->VPGD}}" />
</td>
            </tr> --}}
            <tr>
                <td class="form_name"><label for="Hotline">Hotline</label></td>
                <td class="form_text"><input class="form_control w300" data-val="true" data-val-length="Tối đa 50 ký tự" data-val-length-max="50" id="Hotline" name="Hotline" type="text" value="{{$configSite->Hotline}}" />
<span class="field-validation-valid" data-valmsg-for="Hotline" data-valmsg-replace="true"></span>
</td>
            </tr>
            <tr>
                <td class="form_name"><label for="Email">Email</label></td>
                <td class="form_text"><input class="form_control w300" data-val="true" data-val-email="Email không chính xác" data-val-length="Tối đa 50 ký tự" data-val-length-max="50" id="Email" name="Email" type="text" value="{{ $configSite->Email }}" />
</td>
            </tr>
            {{-- <tr>
                <td class="form_name"><label for="EmailContact">Email phản hồi li&#234;n hệ</label></td>
                <td class="form_text"><textarea class="ckeditor" cols="20" id="test" name="test" rows="2">
{{ $configSite->EmailContact }}
</textarea></td>
            </tr>
            <tr>
                <td class="form_name"><label for="EmailEInvoice">Email phản hồi H&#243;a đơn điện tử</label></td>
                <td class="form_text"><textarea class="ckeditor" cols="20" id="EmailEInvoice" name="EmailEInvoice" rows="2">
                    {{ $configSite->EmailEInvoice }}
</textarea></td>
            </tr> --}}
            {{-- <tr>
                <td class="form_name"><label for="Facebook">Đường dẫn Facebook</label></td>
                <td class="form_text"><input class="form_control w300" data-val="true" data-val-length="Tối đa 500 ký tự" data-val-length-max="500" data-val-url="Đường dẫn không chính xác" id="Facebook" name="Facebook" type="text" value="{{ $configSite->Facebook }}" />
<span class="field-validation-valid" data-valmsg-for="Facebook" data-valmsg-replace="true"></span>
</td>
            </tr>
            <tr>
                <td class="form_name"><label for="Linkedin">Đường dẫn Linkedin</label></td>
                <td class="form_text"><input class="form_control w300" data-val="true" data-val-length="Tối đa 500 ký tự" data-val-length-max="500" data-val-url="Đường dẫn không chính xác" id="Linkedin" name="Linkedin" type="text" value="{{ $configSite->Linkedin }}" />
<span class="field-validation-valid" data-valmsg-for="Linkedin" data-valmsg-replace="true"></span>
</td>
            </tr>
            <tr>
                <td class="form_name"><label for="Twitter">Đường dẫn Twitter</label></td>
                <td class="form_text"><input class="form_control w300" data-val="true" data-val-length="Tối đa 500 ký tự" data-val-length-max="500" data-val-url="Đường dẫn không chính xác" id="Twitter" name="Twitter" type="text" value="{{ $configSite->Twitter }}" />
<span class="field-validation-valid" data-valmsg-for="Twitter" data-valmsg-replace="true"></span>
</td>
            </tr>
            <tr>
                <td class="form_name"><label for="Instagram">Đường dẫn Instagram</label></td>
                <td class="form_text"><input class="form_control w300" data-val="true" data-val-length="Tối đa 500 ký tự" data-val-length-max="500" data-val-url="Đường dẫn không chính xác" id="Instagram" name="Instagram" type="text" value="{{ $configSite->Instagram }}" />
<span class="field-validation-valid" data-valmsg-for="Instagram" data-valmsg-replace="true"></span>
</td>
            </tr>
            <tr>
                <td class="form_name"><label for="Youtube">Đường dẫn Youtube</label></td>
                <td class="form_text"><input class="form_control w300" data-val="true" data-val-length="Tối đa 500 ký tự" data-val-length-max="500" data-val-url="Đường dẫn không chính xác" id="Youtube" name="Youtube" type="text" value="{{ $configSite->Youtube }}" />
<span class="field-validation-valid" data-valmsg-for="Youtube" data-valmsg-replace="true"></span>
</td>
            </tr>
            <tr>
                <td class="form_name"><label for="GoogleMap">M&#227; Google Map</label></td>
                <td class="form_text"><textarea class="multi-line" cols="20" data-val="true" data-val-length="Tối đa 4000 ký tự" data-val-length-max="4000" id="GoogleMap" name="GoogleMap" rows="6">
 {{ $configSite->GoogleMap }}</textarea>
<span class="field-validation-valid" data-valmsg-for="GoogleMap" data-valmsg-replace="true"></span></td>
            </tr>
            <tr>
                <td class="form_name"><label for="GoogleAnalytics">M&#227; Google Analytics</label></td>
                <td class="form_text"><textarea class="multi-line" cols="20" data-val="true" data-val-length="Tối đa 4000 ký tự" data-val-length-max="4000" id="GoogleAnalytics" name="GoogleAnalytics" rows="6">
                    {{ $configSite->GoogleAnalytics }}
</textarea>
<span class="field-validation-valid" data-valmsg-for="GoogleAnalytics" data-valmsg-replace="true"></span></td>
            </tr>
            <tr>
                <td class="form_name"><label for="LiveChat">M&#227; nh&#250;ng Live chat</label></td>
                <td class="form_text"><textarea class="multi-line" cols="20" data-val="true" data-val-length="Tối đa 4000 ký tự" data-val-length-max="4000" id="LiveChat" name="LiveChat" rows="6">
                    {{ $configSite->LiveChat }}
</textarea> --}}
<span class="field-validation-valid" data-valmsg-for="LiveChat" data-valmsg-replace="true"></span></td>
            </tr>
            <tr>
                <td class="form_name"></td>
                <td class="form_text"><input type="submit" class="btn quick-link" value="Cập nhật" /></td>
            </tr>
        </table>
</form></div>
<script>
    $("#updateConfig").validate({
    rules: {
        Name: {
            required: true,
        },
        Image: {
            required: false,
            extension: "jpg|png"
        },
        
    },
    messages: {
        Name: {
            required: "Tên không được để trống",
        },
        Image: {
            extension: "Định dạng phải là jpg hoặc png"
        },
    }
});
</script>
@endsection