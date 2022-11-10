$('.qtybtn').on('click', function () {
    var $button = $(this);
    var oldValue = $button.parent().find('input').val();
    if ($button.hasClass('inc')) {
        var newVal = parseFloat(oldValue) + 1;
    } else {
        // Don't allow decrementing below zero
        if (oldValue > 0) {
            var newVal = parseFloat(oldValue) - 1;
        } else {
            newVal = 0;
        }
    }
    $button.parent().find('input').val(newVal);
    var id = $button.parent().find('input').attr("name");
    $.ajax({
        url: "/UpdateCart/" + id + "/" + newVal,
        method: "GET",
        success: function (res) {
            $('#render-cart').html(res)
            $.ajax({
                url:"/GetCountCart",
                method: "GET",
                success: function(res){
                    $("#count-cart").html(res);
                }
            })           
        }
    });
});
$('.btn-delete-cart').on("click", function () {
    var result = confirm("Bạn có muốn xóa không?");
    if (result) {
        var id = $(this).attr("name");
        $.ajax({
            url: "/DeleteCart/" + id,
            method: "GET",
            success: function (res) {
                $('#render-cart').html(res);
                $.ajax({
                    url:"/GetCountCart",
                    method: "GET",
                    success: function(res){
                        $("#count-cart").html(res);
                    }
                })    
            },
            error: function (res) {
                alert('lỗi không xác định')
                window.location = '/trang-chu';
            }
        });
    }
});