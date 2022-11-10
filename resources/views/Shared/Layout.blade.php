<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="keywords" content="">
    <!-- Page Title -->
    <title>@yield('title')</title>
    <!--Fevicon-->
    <link rel="icon" href="{{ URL::asset('images/logo/logo-TS.jpg')}}" type="image/x-icon" />

    <link rel="stylesheet" href="{{ URL::asset('css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{ URL::asset('css/font-awesome.min.css')}}">
    <link rel="stylesheet" href="{{ URL::asset('css/linear-icon.css')}}">
    <link rel="stylesheet" href="{{ URL::asset('css/plugins.css')}}">
    <link rel="stylesheet" href="{{ URL::asset('css/default.css')}}">
    <link rel="stylesheet" href="{{ URL::asset('css/style.css')}}">
    <link rel="stylesheet" href="{{ URL::asset('css/responsive.css')}}">
    
    <!-- Modernizer JS -->
    <script src="{{ URL::asset('js/vendor/modernizr-3.5.0.min.js')}}"></script>
    <script type="text/javascript" src="{{ URL::asset('js/jquery-3.6.0.min.js')}}"></script>
</head>
<body>
    <?php use App\Http\Controllers\HomeController;
        echo trim(strval(HomeController::renderHeader()))?>
    <div class="main_content">
        @yield('content')
    </div>
    <?php 
        echo trim(strval(HomeController::renderFooter()))?>
    <script src="{{ URL::asset('js/vendor/jquery-1.12.4.min.js')}}"></script>
    <script src="{{ URL::asset('js/popper.min.js')}}"></script>
    <script src="{{ URL::asset('js/bootstrap.min.js')}}"></script>
    <script src="{{ URL::asset('js/plugins.js')}}"></script>
    <script src="{{ URL::asset('js/ajax-mail.js')}}"></script>
    <script src="{{ URL::asset('js/main.js')}}"></script>
    <script>
        $(document).on("click", ".top-search-btn", function (e) {
            let _token = $('input[name="_token"]').val();
            var brand = $(".current").html();
            var key = $('.top-cat-field').val();
            if (key != ''){
                var form = new FormData();
                form.append("_token", _token);
                form.append("brand", brand.toString())
                form.append("keyword", key.toString())
                form.append("page", 1)
                $.ajax({
                    url: window.location.origin+"/tim-kiem-san-pham",
                    data: form,
                    method: "POST",
                    contentType: false,
                    processData: false,
                    async:true,
                    success: function (res) {
                        $('.main_content').html(res)
                    }
                })
            }
            e.preventDefault();
        })
        
        // $(document).on("click", ".btn-cart", function () {
        //     var id = $(this).attr("name")
        //     window.location = "/Cart/AddCart/" + id;
        // });
    </script>
</body>
</html>