@extends('Shared.layout');
@section('title', 'Tin tức')
@section('content')
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
                            @if ($cat!=null)
                                <li class="breadcrumb-item"><a href="{{ URL::asset('/tin-tuc') }}">Tin tức</a></li>
                                <li class="breadcrumb-item active" aria-current="page">{{ $cat->CategoryName }}</li>
                            @else
                                <li class="breadcrumb-item active" aria-current="page">Tin tức</li>
                            @endif
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- breadcrumb area end -->


<div class="blog-area-wrapper pt-30 pb-45">
    <div class="container-fluid">
        <div class="row">
             <div class="col-lg-3">
                <div class="categories-menu-bar cat-menu-style2 cat-header4">
                    <div class="categories-menu-btn bg-4 ha-toggle">
                        <div class="left">
                            <i class="lnr lnr-text-align-left"></i>
                            <span>Tin tức</span>
                        </div>
                        <div class="right">
                            <i class="lnr lnr-chevron-down"></i>
                        </div>
                    </div>
                    <nav class="categorie-menus ha-dropdown">
                        <ul id="menu2">
                            <?php
                            use App\Models\Articlecategory;
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
                                    echo "<li><a href=".$url.">".$cat->CategoryName."</a></li>";
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
                    </nav>
                </div>
             </div>
            <div class="col-lg-9 order-first order-lg-last">
                <div class="blog-wrapper-inner">
                    <div class="row">
                        @foreach ($articles as $item)
                        <div class="col-sm-6 col-lg-4">
                            <div class="single-blogg-item mb-30">
                               <div class="blog-thumb blog--hover">
                                       <a href="{{URL::asset($item->Url)}}"><img src="{{ URL::asset($item->Image) }}" alt="{{ $item->Subject }}"></a>
                               </div>
                               <div class="blogg-content">
                                   <span class="post-date">{{ date("d/m/Y", strtotime($item->CreateDate)); }}</span>
                                   <h5><a style="overflow: hidden;
                                    display: -webkit-box;
                                    -webkit-box-orient: vertical;
                                    -webkit-line-clamp: 3;" href="{{URL::asset($item->Url)}}">{{ $item->Subject }}</a></h5>
                                   <p style="overflow: hidden;
                                   display: -webkit-box;
                                   -webkit-box-orient: vertical;
                                   -webkit-line-clamp: 4;">{{ $item->Description }}</p>
                               </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @if ($page>1)
                <div id="paging">
                    <div class="btn btn-primary btn-paging active">1</div>
                    @for ($i = 2; $i <= $page; $i++)
                        <div class="btn btn-primary btn-paging">{{ $i }}</div>
                    @endfor
                </div>   
                @endif    
            </div>
        </div>
    </div>
</div>
@endsection