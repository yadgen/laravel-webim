$(function () {
    // 登录记住我事件
    $('#remember').click(function() {
        if ($(this).val() == 0) {
            $(this).val(1);
        } else {
            $(this).val(0);
        }
    });

    // 回车触发表单提交
    $(document).keydown(function(event) {
        if (event.keyCode == 13) {
            $('#form_submit').submit();
        }
    });
});