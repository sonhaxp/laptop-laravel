function validateEmail(email) {
	return email.match(
		/^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/
	);
};
function isVietnamesePhoneNumberValid(number) {
    return /(((\+|)84)|0)(3|5|7|8|9)+([0-9]{8})\b/.test(number);
}
function isDateValid(date) {
    return /^\d{4}-\d{1,2}-\d{1,2}$/.test(date);
}
/^\d{1,2}\/\d{1,2}\/\d{4}$/;
$(document).on("click", ".pass-show-btn", function () {
    if ($(this).attr("id") == "hide-newpass") {
        if ($(this).html() == "Hiện") {
            $("#newpassword").attr("type", "text")
            $(this).html("Ẩn")
        }
        else {
            $("#newpassword").attr("type", "password")
            $(this).html("Hiện")
        }
    }
    else {
        if ($(this).html() == "Hiện") {
            $("#c-password").attr("type", "text")
            $(this).html("Ẩn")
        }
        else {
            $("#c-password").attr("type", "password")
            $(this).html("Hiện")
        }
    }
});
$(document).on("click", ".btn-submit-register", function (e) {
    var name = $('#name').val();
    var email = $('#email').val();
    var password = $('#newpassword').val();
    var c_password = $('#c-password').val();
    var birthday = $('#birth').val();
    var phone = $('#phonenumber').val();
    var address = $('#address').val();
    var gender = $('[name="gender"]:radio:checked').val();
    if (name == "" || email == "" || password == "" || c_password == "" || birthday == "" || phone == "" || address == "" || gender == "") {
        alert("Vui lòng nhập đầy đủ thông tin")
        e.preventDefault();
    }
    else {
        if (!validateEmail(email)) {
            alert("email không hợp lệ");
            e.preventDefault();
        }
        else {
            if (password != c_password) {
                alert("mật khẩu không trùng nhau");
                e.preventDefault();
            }
            else {
                if (!isVietnamesePhoneNumberValid(phone)) {
                    alert("số điện thoại không đúng");
                    e.preventDefault();
                }
                else{
                    if(!isDateValid(birthday)){
                        console.log(birthday)
                        alert('Ngày sinh phải nhập đúng định dạng dd/MM/yyyy');
                        e.preventDefault();
                    }
                }
            }
        }
    }
});