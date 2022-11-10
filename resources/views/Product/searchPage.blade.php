<!-- breadcrumb area start -->
<div class="breadcrumb-area mb-30">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="breadcrumb-wrap">
                    <nav aria-label="breadcrumb">
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="/trang-chu">Trang chủ</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{"Tìm kiếm Từ khóa: ".$keyword." Trang ".$pageCurrent }}</li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</div>
@if ($products->count()!=0)
    <div class="main-wrapper pt-35">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12 order-first order-lg-last">
                    <div class="product-shop-main-wrapper mb-50">
                        <div id="product-product-main">
                            @include('product.search')
                            @if ($page>1)
                            <div id="paging">
                                <div class="btn btn-primary btn-paging search active">1</div>
                                @for ($i = 2; $i <= $page; $i++)
                                    <div class="btn btn-primary btn-paging search">{{ $i }}</div>
                                @endfor
                            </div>   
                            @endif        
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@else
    <div><h2 style="text-align: center; color: red;">Không tìm thấy sản phẩm nào phù hợp với từ khóa {{ $keyword }}</h2></div>
@endif
<form action="tim-kiem-san-pham" method="post">
    @csrf
    <input type="text" hidden name="category" value="{{ $cat }}">
    <input type="text" hidden name="key" value="{{ $keyword }}">
</form>
<script src="{{ URL::asset('js/home.js') }}"></script>
<script>
    $(document).on("click", ".btn.btn-primary.btn-paging.search", function () {
        page_product = $(this).html();
        let _token = $('input[name="_token"]').val();
        let category = $('input[name="category"]').val();
        let keyword = $('input[name="key"]').val();
        console.log(page_product);
        console.log(_token);
        console.log(category);
        console.log(keyword);
            if (keyword != ''){
                var form = new FormData();
                form.append("_token", _token);
                form.append("brand", category)
                form.append("keyword", keyword)
                form.append("page", page_product)
                $.ajax({
                    url: window.location.origin+"/tim-kiem-san-pham",
                    data: form,
                    method: "POST",
                    contentType: false,
                    processData: false,
                    success: function (res) {
                        $('.main_content').html(res)
                        $('.btn-paging.active').removeClass('active');
                        $('.btn-paging').get(page_product-1).classList.add('active')
                    }
                })
            }
        })
</script>