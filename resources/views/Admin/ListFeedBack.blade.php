@extends('shared.admin.layout')
@section('title', 'Danh sách phản hồi')
@section('content')
<style>
    img {
        background: #dcdcdc;
    }
</style>
<h2>Danh sách phản hồi</h2>
<div class="box_content">
    <p>Có tổng số <strong>{{ $feedback->count() }}</strong> phản hồi</p>
    <table class="list_table tablecenter table-striped">
        <tbody>
            <tr>
                <th style="width: 100px">Ngày gửi</th>
                <th>Người gửi</th>
                <th>Email</th>
                <th style="width: 400px">Phản hồi</th>
                {{-- <th style="width: 100px"></th> --}}
            </tr>
            @foreach ($feedback as $item)
                <tr data-id="{{ $item->ArticlesId }}">
                    <td>{{ date("d/m/Y H:m:s", strtotime($item->CreateAt)); }}</td>
                    <td>
                        {{ $item->user->Name }}
                    </td>
                    <td>
                        <a href="mailto:{{ $item->user->Email }}">{{ $item->user->Email }}</a>
                    </td>
                    <td>
                        {{ $item->Comment }}
                    </td>
                    {{-- <td>
                        <a href="/Article/UpdateArticle/{{$item->ArticlesId }}">Sửa</a>
                        - <a href="javascript:;" onclick="deleteArticle('{{$item->ArticlesId}}')" class="red-warring">Xóa</a>
                    </td> --}}
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

@endsection