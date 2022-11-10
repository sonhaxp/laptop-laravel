@extends('shared.admin.layout')
@section('title', 'Danh sách bài viết')
@section('content')
<style>
    img {
        background: #dcdcdc;
    }
</style>
<h2>Danh sách tin tức</h2>
<a class="btn quick-link" href="/article/Article"><i class="fal fa-plus-circle mr-1"></i>Thêm bài viết</a>
<div class="box_content">
    <p>Có tổng số <strong>{{ $article->count() }}</strong> bài viết</p>
    <table class="list_table tablecenter table-striped">
        <tbody>
            <tr>
                <th style="width: 100px">Ngày đăng</th>
                <th style="width: 50px">Hình ảnh</th>
                <th style="width: 400px">Tiêu đề</th>
                <th>Danh mục</th>
                <th>Hoạt động</th>
                <th style="width: 100px"></th>
            </tr>
            @foreach ($article as $item)
                <tr data-id="{{ $item->ArticlesId }}">
                    <td>{{ $item->CreateDate }}</td>
                    <td><img src="/{{ $item->Image }}" alt="" width="150"/></td>
                    <td class="left">
                        <a href="/{{ $item->Url }}"><strong>{{ $item->Subject }}</strong></a><br /><br />
                    </td>
                    <td>
                        {{ $item->articlecategory->CategoryName }}
                    </td>
                    <td><input {{ $item->Status==1?"checked":"" }} class="check-box" disabled="disabled" type="checkbox" /></td>
                    <td>
                        <a href="/Article/UpdateArticle/{{$item->ArticlesId }}">Sửa</a>
                        - <a href="javascript:;" onclick="deleteArticle('{{$item->ArticlesId}}')" class="red-warring">Xóa</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

@endsection