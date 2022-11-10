<@php
    use App\Models\Articlecategory;
    use App\Models\Category;
@endphp
<header class="header-pos" style="position: relative; top:-21px;">
    <div class="header-top black-bg">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-6 col-12">
                    <div class="header-top-left">
                        <ul>
                            <li><span>Email: </span><a href="mailto:{{$configSite->Email}}">{{$configSite->Email}}</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-6 col-12">
                    <div class="box box-right">
                        <ul>
                            <li>
                                <div class="main-menu">
                                    <nav id="mobile-menu">
                                        <ul>
                                            <li class="custom-main-menu" style= "
                                            position: relative;
                                            top: 5px;
                                        ">
                                                @if (count($categoryArticle)!=0)
                                                <a href="{{ URL::asset('tin-tuc') }}">Tin tức<span class="lnr lnr-chevron-down"></span></a>
                                                <ul class="dropdown">
                                                    <?php
                                                        $count = 0;
                                                        while(count($categoryArticle)!=0){
                                                            $cat = $categoryArticle->shift();
                                                            $cat->Articlecategory = Articlecategory::whereRaw("ArticleCategoriesParentId = {$cat->ArticleCategoriesId} and Status = 1")->get();
                                                            if(count($cat->Articlecategory)!=0){
                                                                echo "<li><a href=".$cat->Url.">".$cat->CategoryName."<span class='lnr lnr-chevron-right'></span></a>";
                                                                echo "<ul class='dropdown'>";          
                                                                $count++;
                                                                foreach($cat->Articlecategory as $categoryChild){
                                                                    $categoryArticle->prepend($categoryChild);
                                                                }
                                                            }
                                                            else{
                                                                $url = URL::asset($cat->Url);
                                                                echo "<li><a href='".$url."''>".$cat->CategoryName."</a></li>";
                                                                if(count($categoryArticle) > 0){
                                                                    if($categoryArticle[0]->ArticleCategoriesParentId != $cat->ArticleCategoriesParentId){
                                                                        echo "</ul>";
                                                                    }
                                                                } 
                                                                else if($count>0){
                                                                    $count--;
                                                                    echo "</ul></li";
                                                                }
                                                            }
                                                        }
                                                    ?>
                                                </ul>
                                                @else
                                                    <a href="{{ URL::asset('tin-tuc') }}">Tin tức</span></a>
                                                @endif
                                                
                                            </li>
                                        </ul>
                                    </nav>
                                </div>
                            </li>
                            <li><a href="{{ URL::asset('phan-hoi') }}">Phản hồi</a></li>
                            <li>
                                <a href="{{ URL::asset('gioi-thieu') }}">Giới thiệu</a>
                            </li>
                            <li>
                                <a href="{{ URL::asset('lien-he') }}">Liên hệ</a>
                            </li>
                            <li class="settings">
                                @if ($user == null)
                                    <a class="ha-toggle" href="{{ URL::asset('#') }}">Tài khoản<span class="lnr lnr-chevron-down"></span></a>
                                    <ul class="box-dropdown ha-dropdown">
                                        <li><a href="{{ URL::asset('dang-ky') }}">Đăng kí</a></li>
                                        <li><a href="{{ URL::asset('dang-nhap') }}">Đăng nhập</a></li>
                                    </ul>
                                @else
                                    <a class="ha-toggle" href="{{ URL::asset('#') }}">{{$user->Name}}<span class="lnr lnr-chevron-down"></span></a>
                                    <ul class="box-dropdown ha-dropdown">
                                        <li><a href="{{ URL::asset('thong-tin') }}">Thông tin</a></li>
                                        <li><a href="{{ URL::asset('dang-xuat') }}">Đăng xuất</a></li>
                                    </ul>
                                @endif
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="header-middle home-header2 theme-bg">
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="col-lg-3 col-md-4 col-sm-4 col-12">
                    <div class="logo">
                        <a href="/trang-chu"><img src="{{ URL::asset('images/logo/logo-TS.jpg') }}" alt="brand-logo"></a>
                    </div>
                </div>
                <div class="col-lg-7 col-md-12 col-12 order-sm-last">
                    <div class="header-middle-inner">
                        <form action="{{ URL::asset('tim-kiem-san-pham') }}">
                            @csrf
                            <div class="top-cat hm1">
                                <div class="search-form">
                                    <div class="nice-select" tabindex="0">
                                        <span class="current">Tất cả</span>
                                        <ul class="list">
                                            <li data-value="0" class="option selected">Tất cả</li>
                                            @foreach ($category->filter(function($cat)
                                            {
                                                return $cat->ParentCategoryId == null;
                                            }) as $cat)
                                                <li data-value="{{ $cat->CategoryId }}" class="option selected">{{ $cat->Name }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <input type="text" name="keyword" class="top-cat-field" placeholder="Tìm kiếm" >
                            <input type="submit" class="top-search-btn" value="Tìm kiếm">
                        </form>
                    </div>
                </div>
                <div class="col-lg-2 col-md-8 col-12 col-sm-8 order-lg-last">
                    <div class="mini-cart-option">
                        <ul>
                            <li class="my-cart">
                                <a class="ha-toggle" href="/gio-hang"><span class="lnr lnr-cart"></span><span class="count" id="count-cart">{{ $cart }}</span>Giỏ hàng</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="header-top-menu theme-bg sticker">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="top-main-menu">
                        <div class="main-menu menu-style3">
                            <nav id="mobile-menu" data-screen="1199" class="m-style3" style="display: block;">
                                <ul>
                                    @php
                                        foreach ($category as $cat) {
                                            $cat->Category = Category::whereRaw("ParentCategoryId = {$cat->CategoryId} and Status = 1")->get();
                                            if(count($cat->Category)!=0){
                                                echo "<li><a href='{$cat->Url}'><img src='{$cat->Image}' alt='{$cat->Description}'><span>{$cat->Name}<i class='lnr lnr-chevron-down'></i></span></a>";
                                                echo "<ul class='dropdown'>";
                                                $count = 0;
                                                $catTemp = $cat->Category;
                                                while(count($catTemp)!=0){
                                                    $cat = $catTemp->shift();
                                                    $cat->Category = Category::whereRaw("ParentCategoryId = {$cat->CategoryId} and Status = 1")->get();
                                                    if(count($cat->Category)!=0){
                                                        echo "<li><a href=".URL::asset($cat->Url).">".$cat->Name."<span class='lnr lnr-chevron-right'></span></a>";
                                                        echo "<ul class='dropdown'>";          
                                                        $count++;
                                                        foreach($cat->Category as $categoryChild){
                                                            $catTemp->prepend($categoryChild);
                                                        }
                                                    }
                                                    else{
                                                        echo "<li><a href=".URL::asset($cat->Url).">".$cat->Name."</a></li>";
                                                        if(count($catTemp) > 0){
                                                            if($catTemp[0]->ParentCategoryId != $cat->ParentCategoryId){
                                                                echo "</ul>";
                                                            }
                                                        } 
                                                        else if($count>0){
                                                            $count--;
                                                            echo "</ul></li";
                                                        }
                                                    }     
                                                }
                                                echo "</ul>"; 
                                            }
                                            else{
                                                echo "<li><a href=".URL::asset($cat->Url)."><img src='{$cat->Image}' alt='{$cat->Description}'><span>{$cat->Name}</span></a></li>";
                                            }
                                               
                                        }
                                        
                                    @endphp
                                </ul>
                            </nav>
                        </div> <!-- </div> end main menu -->
                    </div>
                </div>
                <div class="col-12 d-block d-xl-none"><div class="mobile-menu m-style3"></div></div>
            </div>
        </div>
    </div>
</header>

<script>
    /*Header Cart
		-----------------------------------*/
		var headerActionToggle = $('.ha-toggle');
		var headerActionDropdown = $('.ha-dropdown');
		// Toggle Header Cart
		headerActionToggle.on("click", function() {
			var $this = $(this);
			headerActionDropdown.slideUp();
			if($this.siblings('.ha-dropdown').is(':hidden')){
				$this.siblings('.ha-dropdown').slideDown();
			} else {
				$this.siblings('.ha-dropdown').slideUp();
			}
		});
		// Prevent closing Header Cart upon clicking inside the Header Cart
		$('.ha-dropdown').on('click', function(e) {
			e.stopPropagation();
		});
</script>