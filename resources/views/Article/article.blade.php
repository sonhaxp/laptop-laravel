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
                            <li class="breadcrumb-item"><a href="{{ URL::asset('/tin-tuc') }}">Tin tức</a></li>
                            <li class="breadcrumb-item"><a href="{{ URL::asset($article->Articlecategory->Url) }}">{{$article->Articlecategory->CategoryName}}</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{ $article->Subject }}</li>
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
                        <div class="single-blogg-item mb-30">
                            <h2 style="font-size: 32px;
                            line-height: 40px;
                            margin-bottom: 20px;
                            font-weight: 600;
                            margin-top: 16px;">{{$article->Subject}}</h2>
                            <span class="post-date">{{ date("d/m/Y", strtotime($article->CreateDate)); }}</span>
                            <div class="blogg-content">
                                {!! $article->Body !!}
                            </div>
                        </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection