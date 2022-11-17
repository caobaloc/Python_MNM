(function($) {
    var filterEmail = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;

    $('#form_submit').on('click', function() {
        var i = 0;
        $('.form-gp input').each(function() {
            if(!$(this).val()){
                var fieldName = $(this).attr("field-name");
                $(this).parent('.form-gp').find('.text-danger').text("Vui lòng nhập " + fieldName + "!");
                    i++;
            }
        });
        if(i==0){
            if(!filterEmail.test($("#exampleInputEmail1").val())){
                $("#error_RePassWord").text("Email không hợp lệ!");
            }
            else{
                if($("#exampleInputPassword1").val() == $("#exampleInputPassword2").val())
                    $("#register-form").submit();
                else
                    $("#error_RePassWord").text("Mật khẩu xác nhận không trùng khớp!");
            }
        }
    });

})(jQuery);