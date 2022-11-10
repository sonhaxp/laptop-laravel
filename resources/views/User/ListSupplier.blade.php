@extends('shared.admin.layout')
@section('title', 'Danh sách nhà cung cấp')
@section('content')
<style>
    img {
        background: #dcdcdc;
    }
</style>
<h2>Danh sách nhà cung cấp</h2>
<a class="btn quick-link" href="/user/User"><i class="fal fa-plus-circle mr-1"></i>Thêm nhà cung cấp</a>
<div class="box_content">
    <p>Có tổng số <strong>{{ $user->count() }}</strong> nhà cung cấp</p>
    <table class="list_table tablecenter table-striped">
        <tbody>
            <tr>
                <th>Họ tên</th>
                <th>Email</th>
                <th>Điện thoại</th>
                <th>Địa chỉ</th>
                <th>Trạng thái</th>
                <th style="width: 100px"></th>
            </tr>
            @foreach ($user as $item)
                <tr data-id="{{ $item->UserId }}">
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