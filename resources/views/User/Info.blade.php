@extends('Shared.layout');
@section('title', 'Thông tin của '.$user->Name)
@section('content')
@php
    use Carbon\Carbon;
@endphp
<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
<link href="{{ URL::asset('css/info.css') }}" rel="stylesheet" />
<!-- Begin-main -->
<!-- breadcrumb area start -->
<div class="breadcrumb-area mb-30">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="breadcrumb-wrap">
                    <nav aria-label="breadcrumb">
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ URL::asset('/trang-chu') }}">Trang chủ</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Thông tin</li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- breadcrumb area end -->
@if ($errors->has('password')==true)
    <div class="login-box mt-5 text-center">
        <p style="color:red"><strong>{{ $errors->first('password') }}</strong></p>
    </div>
@endif
<div class="member__main">
    <div class="grid wide ">
        <div class="row app_container">
            <div class="col l-12">
                <!-- Begin nav-tab-member -->
                <ul class="nav-tab-member">
                    <li class="tab-member__item" id="tab_info">
                        <p id="js-information" class="tab-member__link--info tab-member-color-active cursor-default">THÔNG TIN THÀNH VIÊN</p>
                    </li>
                    <li class="tab-member__item" id="tab_transaction">
                        <p id="js-transaction" class="tab-member__link--trans cursor-pointer">GIAO DỊCH CỦA TÔI</p>
                    </li>
                </ul>
                <!-- End nav-tab-member -->
            </div>
        </div>
        <!--Begin member-body -->
        <div class="member-body-wrap">
            <form action="ChangeInfo" method="post">
            @csrf
            <!-- row-one -->
            <div class="row tablet-pd-20 mobile-pd-10  ">
                <div class="col l-5 m-7 c-12">
                    <label for="" class="lable-text">Họ & Tên</label>
                    <input type="text" value="{{ $user->Name }}" disabled class="input-member">
                </div>
                <div class="col l-2 m-7 c-12">
                    <label for="" class="lable-text ">Chi tiêu {{ Carbon::now()->year; }}</label>
                    <input type="text" value="{{ number_format($chitieu, 0, '', ',')."vnđ" }}" disabled class="input-member">
                </div>
            </div>
            <!-- row-two -->
            <div class="row   tablet-pd-20 mobile-pd-10 mb-mt-0  row-mt">
                <div class="col c-12 l-3 m-8 ">
                    <label for="" class="lable-text">Ngày sinh</label>
                    <input type="text" value="{{ $user->Birthday->format('d-m-Y') }}" disabled class="input-member">
                </div>
                <div class="col c-12 l-2 m-8 mb-mt-20">
                    <label for="" class="lable-text">Giới tính</label>
                    <input type="text" value="{{ $user->Gender }}" disabled class="input-member">
                </div>
                <div class="col c-12 l-3 m-8  tl-mt-20 mb-mt-20">
                    <label for="" class="lable-text ">Số điện thoại</label>
                    <input type="text" value="{{ $user->PhoneNumber }}" disabled class="input-member">
                </div>
            </div>
            <!-- row-three -->
            <div class="row   tablet-pd-20 mobile-pd-10  ">
                <div class="col c-12 l-5 m-12 mt-20 row-mt tl-mt-0 mb-mt-0">
                    <label for="q" class="lable-text">Địa chỉ</label>
                    <input type="text" value="{{ $user->Address }}" id="address" name="address" class="input-member--enable">
                </div>
            </div>
            <!-- row-four -->
            <div class="row tablet-pd-20 mobile-pd-10 row-mt mb-mt-0">
                <div class="col l-5 m-12 c-12">
                    <label for="q" class="lable-text">Email</label>
                    <input type="email" name="" value="{{ $user->Email }}" disabled class="input-member">
                </div>

            </div>
            <!-- row-five -->
            <div class="row tablet-pd-20 mobile-pd-10  row-mt">
                <div class="col l-5 c-12 m-12">
                    <input type='hidden' value='0' name='flag'>
                    <input type="checkbox" name="flag" id="changepass__checkbox" class="changepass__checked">
                    <label for="changepass__checkbox" class="changepass__text">
                        Đổi mật khẩu
                    </label>
                    <!-- Modal -->
                    <!--Begin input-change-password -->
                    <div class="modal-change-password ">
                        <input type="password" placeholder="Mật khẩu hiện tại" class="input-member--enable" id="pass_older" name="password_old">
                        <input type="password" placeholder="Mật khẩu mới" class="input-member--enable" id="pass_new" name="password_new">
                        <input type="password" placeholder="Xác nhận mật khẩu" class="input-member--enable" id="pass_new2">
                    </div>
                    <!--End input-change-password -->
                    <!-- btn-save -->
                    
                    <input class="btn-save" style="border: none" type="submit" value="LƯU LẠI">
                </form>
                </div>

            </div>
            <!--End member-body -->
        </div>
        <!-- Modal Transaction -->
        <div class="modal-transaction">
            <div class="modal-container">
                <div class="grid wide">
                    {{-- <div class="row date-wrap">
                        <div class="col l-3 m-12 c-12">
                            <label class="lable-text" for="">Từ</label>
                            @{
                                DateTime d = DateTime.Now;
                                d = d.AddMonths(-1);
                                string[] a = d.ToString().Split(' ')[0].Split('/');
                                string t = a[2] + '-' + a[1] + '-' + a[0];

                                <input type="date" id="date_from" value="@t" onchange="load_hd()" class="input-member--enable">
                            }
                        </div>
                        <div class="col l-3 m-12 c-12 film-heading__mt">
                            <label class="lable-text" for="">Đến</label>
                            @{
                                DateTime dt = DateTime.Now;
                                string[] a1 = dt.ToString().Split(' ')[0].Split('/');
                                string t1 = a1[2] + '-' + a1[1] + '-' + a1[0];
                                <input type="date" id="date_to" value="@t1" onchange="load_hd()" class="input-member--enable">
                            }
                        </div>
                    </div> --}}
                    <div class="row detail-wrap">
                        <div class="col l-12 m-12 c-12">
                            <table>
                                <thead class="head-table">
                                    <tr>
                                        <th>Ngày</th>
                                        <th>Mã hóa đơn</th>
                                        <th>Giá trị</th>
                                        <th>Người nhận</th>
                                        <th>Số điện thoại</th>
                                        <th>Địa chỉ</th>
                                        <th>Email</th>
                                        <th>Trạng thái</th>
                                        <th>Thao tác</th>
                                    </tr>
                                </thead>
                                <tbody class="body-table" id="data-table">
                                    @foreach ($orders as $item)
                                    <tr>
                                        <th>{{ $item->CreateAt->format('d-m-Y') }}</th>
                                        <th>{{ $item->OrderId }}</th>
                                        <th>{{ number_format($item->TongTien, 0, '', ',')."vnđ" }}</th>
                                        <th>{{ $item->Receiver }}</th>
                                        <th>{{ $item->PhoneNumber }}</th>
                                        <th>{{ $item->Address }}</th>
                                        <th>{{ $item->Email }}</th>
                                        <th>{{ $item->attributevalue->Value }}</th>
                                        <th><a href="#" title="Xem chi tiết" data-target="#quickk_view" data-toggle="modal" name="{{ $item->OrderId }}" id="show-transaction">Chi tiết</a></th>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End  Modal Transaction -->
    </div>
</div>
<div class="modal fade" id="quickk_view">
    <div class="container">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    
                </div>
            </div>
        </div>
    </div>
</div>
<script src="{{URL::asset('js/info.js')}}"></script>

@endsection

