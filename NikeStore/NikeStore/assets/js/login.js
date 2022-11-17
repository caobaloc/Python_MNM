(function($) {

    $('#form_submit').on('click', function() {
        var i = 0;
        $('.form-gp input').each(function() {
            if(!$(this).val()){
                var fieldName = $(this).attr("field-name");
                $(this).parent('.form-gp').find('.text-danger').text("Vui lòng nhập " + fieldName + "!");
                    i++;
            }
        });
        if(i==0)
            $("#login-form").submit();
    });

})(jQuery);