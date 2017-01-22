$(function () {
    var animationLibrary = 'animate';
    $.easing.easeOutQuart = function (x, t, b, c, d) {
        return -c * ((t = t / d - 1) * t * t * t - 1) + b;
    };
    $('[ripple]:not([disabled],.disabled)').on('mousedown', function (e) {
        var button = $(this);
        var touch = $('<touch><touch/>');
        var size = button.outerWidth() * 1.8;
        var complete = false;
        $(document).on('mouseup', function () {
            var a = { 'opacity': '0' };
            if (complete === true) {
                size = size * 1.33;
                $.extend(a, {
                    'height': size + 'px',
                    'width': size + 'px',
                    'margin-top': -size / 2 + 'px',
                    'margin-left': -size / 2 + 'px'
                });
            }
            touch[animationLibrary](a, {
                duration: 500,
                complete: function () {
                    touch.remove();
                },
                easing: 'swing'
            });
        });
        touch.addClass('touch').css({
            'position': 'absolute',
            'top': e.pageY - button.offset().top + 'px',
            'left': e.pageX - button.offset().left + 'px',
            'width': '0',
            'height': '0'
        });
        button.get(0).appendChild(touch.get(0));
        touch[animationLibrary]({
            'height': size + 'px',
            'width': size + 'px',
            'margin-top': -size / 2 + 'px',
            'margin-left': -size / 2 + 'px'
        }, {
            queue: false,
            duration: 500,
            'easing': 'easeOutQuart',
            'complete': function () {
                complete = true;
            }
        });
    });

    // 回车事件
    $(document).keydown(function(event) {
        if (event.keyCode == 13) {
            $('#form_login').submit();
        }
    });
});

var user_name = $('#user_name'),
    password = $('#password'),
    password_confirmation = $('#password_confirmation'),
    email = $('#email'),
    submit = $('#submit'),
    udiv = $('#u'),
    pdiv = $('#p'),
    pcdiv = $('#pc'),
    ediv = $('#e');
user_name.blur(function () {
    if (user_name.val() == '') {
        udiv.attr('errr', '');
    } else {
        udiv.removeAttr('errr');
    }
});
password.blur(function () {
    if (password.val() == '') {
        pdiv.attr('errr', '');
    } else {
        pdiv.removeAttr('errr');
    }
});
password_confirmation.blur(function () {
    if (password_confirmation.val() == '') {
        pcdiv.attr('errr', '');
    } else {
        pcdiv.removeAttr('errr');
    }
});
email.blur(function () {
    if (email.val() == '') {
        ediv.attr('errr', '');
    } else {
        ediv.removeAttr('errr');
    }
});
submit.on('click', function (event) {
    var status = 0;

    if (user_name.val() == '') {
        udiv.attr('errr', '');

        status = 1;
    } else {
        udiv.removeAttr('errr');
    }

    if (password.val() == '') {
        pdiv.attr('errr', '');

        status = 1
    } else {
        pdiv.removeAttr('errr');
    }

    if (password_confirmation.val() == '') {
        pcdiv.attr('errr', '');

        status = 1
    } else {
        pcdiv.removeAttr('errr');
    }

    if (email.val() == '') {
        ediv.attr('errr', '');

        status = 1;
    } else {
        ediv.removeAttr('errr');
    }

    if (status == 1) {
        return false;
    }

    return true;
});