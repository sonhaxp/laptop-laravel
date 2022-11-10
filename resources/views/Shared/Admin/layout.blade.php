

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>@yield('title')</title>
    <link rel="icon" href="{{ URL::asset('images/logo/logo-TS.jpg')}}" type="image/x-icon" />
    <link href="{{ URL::asset('css/bootstrap.min.css') }}" rel="stylesheet"/>
    <link href="{{ URL::asset('css/all.css') }}" rel="stylesheet"/>
    <link href="{{ URL::asset('css/adminSite.css') }}" rel="stylesheet"/>
    <link href="{{ URL::asset('js/multi-upload/jquery.fileupload.css') }}" rel="stylesheet"/>
    
    <link rel="stylesheet" href="{{ URL::asset('css/font-awesome.min.css')}}">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
    
    <script src="{{ URL::asset('js/jquery-3.6.0.min.js') }}"></script>
    <script src="{{ URL::asset('js/jquery.validate.min.js') }}"></script>
    <style>
        label.error{
            color: red;
            margin-left: 20px;
        }
        div.success{
            color: green;
            margin-left: 20px;
        }
    </style>
    
</head>
<body>
    @php
        use App\Models\Configsite;
        $configSite = Configsite::first();
        $admin = session('admin');
    @endphp
    <div id="responsive">
        <div class="app-header">
            <div class="app-header__logo">
                    <a href="/" target="_blank"><img class="logo-admin" src="{{URL::asset($configSite->Image)}}" alt="logo" /></a>
                
                <a id="btn-show" onclick="myFunction()"><i class="fal fa-bars"></i><i class="fal fa-times"></i></a>
            </div>
            <div class="app-header__content">
                <div class="media mr-lg-5 mr-3 drop">
                    <img class="mr-3 avatar" src="{{ URL::asset('css/admin/icon_profile.png') }}" />
                    <div class="media-body">
                        <h5 class="mb-0">{{ $admin->Name }}</h5>
                        {{ $admin->Attributevalue->Value }}
                    </div>
                    <div class="content-drop">
                        <a href="/admin/LogOut"><i class="fal fa-sign-out-alt pr-1"></i> Đăng xuất</a>
                        <a href="/admin/changePass"><i class="fal fa-low-vision mr-1"></i>Đổi mật khẩu</a>
                        <a href="/admin/ConfigSite"><i class="fal fa-info-circle"></i> Thông tin chung</a>
                    </div>
                </div>
                <a id="help" class="drop" onclick="fbFunction()">
                    <i class="fas fa-user-headset"></i>
                    <div class="content-drop">Gửi yêu cầu cho chúng tôi</div>
                </a>
            </div>
        </div>
        <div id="left_menu_profile">
            <div class="left_menu_profile">
                <ul class="drop-bar">
                    <li data-id="5">
                        <a class="root expand mb-3" href="/admin">Tổng quan website</a>
                    </li>
                    <li data-id="0">
                        <a class="root"><span>Admin</span><i class="fas fa-caret-down"></i></a>
                        <div class="sub hidden">
                            <div><a class="text_link" href="/admin/changePass">Đổi mật khẩu</a></div>
                            <div><a class="text_link" href="/admin/ListAdmin">Quản lý admin</a></div>
                            <div><a class="text_link" href="/admin/ConfigSite">Thông tin chung</a></div>
                            <div><a class="text_link" href="/admin/Logout">Đăng xuất</a></div>
                        </div>
                    </li>
                    <li data-id="1">
                        <a class="root"><span>Quản lý Tin tức</span><i class="fas fa-caret-down"></i></a>
                        <div class="sub hidden">
                            <div><a class="text_link" href="/article/CategoryArticle">Th&#234;m danh mục</a></div>
                            <div><a class="text_link" href="/article/Article">Th&#234;m mới b&#224;i viết</a></div>
                            <div><a class="text_link" href="/article/ListArticle">Danh s&#225;ch b&#224;i viết</a></div>
                        </div>
                    </li>
                    <li data-id="2">
                        <a class="root"><span>Quản lý Danh mục</span><i class="fas fa-caret-down"></i></a>
                        <div class="sub hidden">
                            <div><a class="text_link" href="/category/CreateCategory">Th&#234;m mới danh mục</a></div>
                            <div><a class="text_link" href="/brand/CreateBrand">Th&#234;m mới thương hiệu</a></div>
                            <div><a class="text_link" href="/attribute/CreateAttribute">Th&#234;m mới thuộc tính</a></div>
                            <div><a class="text_link" href="/attribute/CreateAttributeValue">Th&#234;m mới giá trị thuộc tính</a></div>
                            <div><a class="text_link" href="/category/CreateBrandCategory">Thêm thương hiệu - danh mục</a></div>
                            <div><a class="text_link" href="/category/CreateAttributeCategory">Thêm thuộc tính - danh mục</a></div>
                        </div>
                    </li>
                    <li data-id="3">
                        <a class="root"><span>Quản lý Sản phẩm</span><i class="fas fa-caret-down"></i></a>
                        <div class="sub hidden">
                            <div><a class="text_link" href="/product/CreateProduct">Th&#234;m mới sản phẩm</a></div>
                            <div><a class="text_link" href="/product/ListProduct">Danh s&#225;ch sản phẩm</a></div>
                            <div><a class="text_link" href="/purchase/ListPurchase">Danh s&#225;ch phiếu nhập kho</a></div>
                            <div><a class="text_link" href="/purchase/CreatePurchase">Thêm phiếu nhập kho</a></div>
                        </div>
                    </li>
                    <li data-id="3">
                        <a class="root"><span>Quản lý đơn hàng</span><i class="fas fa-caret-down"></i></a>
                        <div class="sub hidden">
                            <div><a class="text_link" href="/order/ListOrder">Danh sách đơn hàng</a></div>
                        </div>
                    </li>
                    <li data-id="4">
                        <a class="root"><span>Quản lý KH & NCC</span><i class="fas fa-caret-down"></i></a>
                        <div class="sub hidden">
                            <div><a class="text_link" href="/user/User">Thêm mới nhà cung cấp</a></div>
                            <div><a class="text_link" href="/user/ListCustomer">Danh s&#225;ch kh&#225;ch h&#224;ng</a></div>
                            <div><a class="text_link" href="/user/ListSupplier">Danh s&#225;ch nhà cung cấp</a></div>
                        </div>
                    </li>
                    <li data-id="2">
                        <a class="root"><span>Quản lý Phản hồi</span><i class="fas fa-caret-down"></i></a>
                        <div class="sub hidden">
                            <div><a class="text_link" href="/admin/ListFeedback">Danh s&#225;ch phản hồi</a></div>
                        </div>
                    </li>
                    <li data-id="7">
                        <a class="root"><span>Quản lý Quảng cáo</span><i class="fas fa-caret-down"></i></a>
                        <div class="sub hidden">
                            <div><a class="text_link" href="/admin/CreateBanner">Th&#234;m mới quảng c&#225;o</a></div>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
        <div id="content_center_right">
            <div class="content_center_right">
                @yield('content')
            </div>
        </div>
    </div>
    <script src="{{ URL::asset('js/jquery-ui-1.12.1.min.js') }}"></script>
    <script src="{{ URL::asset('js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ URL::asset('js/multi-upload/jquery.iframe-transport.js') }}"></script>
    <script src="{{ URL::asset('js/multi-upload/jquery.fileupload.js') }}"></script>
    <script src="{{ URL::asset('js/ckeditor/ckeditor.js') }}"></script>
    <script src="{{ URL::asset('js/ckeditor/adapters/jquery.js') }}"></script>
    <script src="{{ URL::asset('js/jquery.fancybox.js') }}"></script>
    <script src="{{ URL::asset('js/jquery.toast.js') }}"></script>
    <script src="{{ URL::asset('js/jquery.cookie.js') }}"></script>
    <script src="{{ URL::asset('js/scriptAdmin.js') }}"></script>
    {{-- <script src="/bundles/jquery?v=9ktsOtIo0upvJP7-7FiXuOoOJe58RLFJ__wIRPL2vGo1"></script>
    <script src="/bundles/jqueryval?v=1JOva1TtAasjAVPR4sIF9tSsHrK0L4EZcerlvIb-z3U1"></script>
    <script src="/bundles/jqueryui?v=yqCVigxSu97_s_vulMWzX97PVmpAp1RUApV3df4vSeo1"></script> --}}
    <script src="https://code.jquery.com/jquery-migrate-3.3.0.min.js"></script>
</body>
</html>
