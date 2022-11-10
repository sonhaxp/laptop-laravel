@extends('shared.admin.layout')
@section('title', 'Danh sách khách hàng')
@section('content')
<style>
    img {
        background: #dcdcdc;
    }
</style>
<h2>Danh sách khách hàng</h2>
<a class="btn quick-link" href="/user/User"><i class="fal fa-plus-circle mr-1"></i>Thêm khách hàng</a>
<div class="box_content">
    <p>Có tổng số <strong>{{ $user->count() }}</strong> khách hàng</p>
    <table class="list_table tablecenter table-striped">
        <tbody>
            <tr>
                <th>Tên đăng nhập</th>
                <th>Họ tên</th>
                <th>Email</th>
                <th>Điện thoại</th>
                <th>Địa chỉ</th>
                <th>Trạng thái</th>
                <th style="width: 100px"></th>
            </tr>
            @foreach ($user as $item)
                <tr data-id="{{ $item->UserId }}">
                    <td>{{ $item->UserName }}</td>
                    <td>{{ $item->Name }}</td>
                    <td>{{ $item->Email }}</td>
                    <td>{{ $item->PhoneNumber }}</td>
                    <td>{{ $item->Address }}</td>
                    <td><input {{ $item->Status==1?"checked":"" }} class="check-box" disabled="disabled" type="checkbox" /></td>
                    <td>
                        <a href="/User/UpdateUser/{{$item->UserId }}">Sửa</a>
                        - <a href="javascript:;" onclick="deleteUser('{{$item->UserId}}')" class="red-warring">Xóa</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

@endsection