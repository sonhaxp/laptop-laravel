function IndexJs() {
    $(".banner-owl").owlCarousel({
        loop: true,
        nav: true,
        animateOut: "fadeOut",
        smartSpeed: 10,
        navText: ["<i class='fal fa-angle-left'></i>", "<i class='fal fa-angle-right'></i>"],
        autoplay: true,
        items: 1
    });
    $(".article-owl").owlCarousel({
        margin: 20,
        loop: false,
        nav: true,
        navText: ["<i class='fal fa-angle-left'></i>", "<i class='fal fa-angle-right'></i>"],
        autoplay: false,
        responsive: {
            0: {
                items: 2
            },
            600: {
                margin: 15,
                items: 3
            },
            1000: {
                items: 4
            }
        }
    });
    $(".feedback-owl").owlCarousel({
        margin: 25,
        loop: false,
        nav: true,
        navText: ["<i class='fal fa-angle-left'></i>", "<i class='fal fa-angle-right'></i>"],
        autoplay: false,
        responsive: {
            0: {
                items: 1
            },
            600: {
                margin: 20,
                items: 2
            },
            1000: {
                items: 3
            }
        }
    });
    $(".partner-owl").owlCarousel({
        margin: 30,
        loop: false,
        nav: false,
        navText: ["<i class='fal fa-angle-left'></i>", "<i class='fal fa-angle-right'></i>"],
        autoplay: true,
        responsive: {
            0: {
                items: 3,
                margin: 15
            },
            600: {
                margin: 20,
                items: 4
            },
            1000: {
                items: 6
            }
        }
    });
}

function ShowMenu() {
    var x = document.getElementById("menu");
    if (x.className === "shadow-top py-2") {
        x.className += " show-menu";
    } else {
        x.className = "shadow-top py-2";
    }
}

AOS.init();
var zero = 0;
$(window).on("scroll", function () {
    $(".shadow").toggleClass("hidden", $(window).scrollTop() > zero);
    zero = $(window).scrollTop();

    if ($(window).scrollTop() > 200) {
        $("#goTop").fadeIn();
        $("#menu").addClass("menu-small");
    } else {
        $("#goTop").fadeOut();
        $("#menu").removeClass("menu-small");
    }
});

$(window).on("load", function () {
    $(".counter").counterUp({
        delay: 25,
        time: 2500
    });
    $(".search-mobile").on("click", function () {
        $(".form-search").show();
    });
    $(".close-search").on("click", function () {
        $(".form-search").hide();
    });

    $("#contact_form").on("submit", function (e) {
        e.preventDefault();
        $.post("/Home/Contact", $(this).serialize(), function (data) {
            if (data.status) {
                //alert(data.msg);
                $.toast({
                    heading: 'Gửi liên hệ thành công',
                    text: 'Chúng tôi sẽ liên hệ lại với bạn sớm nhất có thể !!',
                    position: 'top-center',
                    icon: 'success',
                })
                $("#contact_form").trigger("reset");
            }
            else {
                //alert(data.msg);
                $.toast({
                    heading: 'Gửi thất bại',
                    text: 'Vui lòng điền đúng định dạng',
                    icon: 'error',
                })
            }
        });
    });

    $("#register_form").on("submit", function (e) {
        e.preventDefault();
        if ($(this).valid()) {
            $.post("/Home/Register", $(this).serialize(), function (data) {
                if (data.status) {
                    $.toast({
                        heading: 'Đăng ký thành công',
                        text: data.msg,
                        position: 'top-center',
                        icon: 'success'
                    });
                    $("#register_form").trigger("reset");
                }
                else {
                    $.toast({
                        heading: 'Đăng ký không thành công',
                        text: data.msg,
                        icon: 'error'
                    });
                }
            });
        }
    });

    var $inputItem = $(".js-inputWrapper");
    $inputItem.length && $inputItem.each(function () {
        var $this = $(this),
            $input = $this.find(".formRow--input"),
            placeholderTxt = $input.attr("placeholder"),
            $placeholder;

        $input.after('<span class="placeholder">' + placeholderTxt + "</span>"),
            $input.attr("placeholder", ""),
            $placeholder = $this.find(".placeholder"),

            $input.val().length ? $this.addClass("active") : $this.removeClass("active"),

            $input.on("focusout", function () {
                $input.val().length ? $this.addClass("active") : $this.removeClass("active");
            }).on("focus", function () {
                $this.addClass("active");
            });
    });

});