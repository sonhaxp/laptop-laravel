function validateEmail(email) {
    return email.match(
        /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/
    );
};
$(document).on("click", ".pass-show-btn", function () {
        if ($(this).html() == "Hiện") {
            $("#password").attr("type", "text")
            $(this).html("Ẩn")
        }
        else {
            $("#password").attr("type", "password")
            $(this).html("Hiện")
        }
});
$(document).on("click", ".btn-submit-login", function (e) {
    var email = $('#email').val();
    var password = $('#password').val();
    if (email == "" || password == "") {
        alert("Vui lòng nhập đầy đủ thông tin");
        e.preventDefault();
    }
    else {
        if (!validateEmail(email)) {
            alert("email không hợp lệ");
            e.preventDefault();
        }
    }
});