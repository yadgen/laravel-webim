$(function() {
    var ws = $.WebSocket("ws://" + server_addr + ":"+port+"");

    ws.onopen = function() {
        var data = '{"message_type":4, "user_id":"'+user_id+'", "user_name":"'+user_name+'"}';
        ws.send(data);
        console.log("socket is open.");
    };
    ws.onclose = function(e) {
        console.log("socket is close."+e.data);
    };
    ws.onerror = function(e) {
        console.log("socket is error."+e.data);
    };
    ws.onmessage = function(e) {
        var data = $.evalJSON(e.data);
        switch (data.message_type) {
            case 1: // onopen
                $('#online_user_list').append(data.message);
                $('#online_user_list_count').html(data.online_user_list_count);
                break;
            case 2: // onclose
                $('.online_user_list_'+data.user_id).remove();
                $('#online_user_list_count').html(data.online_user_list_count);
                break;
            case 3: // 用户消息
                $('#message_list').append(data.message);
                var message_list_height = parseInt($('#message_list').height());
                $('.chat-body').scrollTop(message_list_height + 34);
                break;
            case 4: // 系统消息
                $('#message_list').append(data.message);
                var message_list_height = parseInt($('#message_list').height());
                $('.chat-body').scrollTop(message_list_height + 34);
                break;
            default:
                console.log('message_type error');
        }
    };

    $("#send").click(function() {
        var message = $("#message").val();
        if (message == "") {
            return false;
        }
        $("#message").val("");

        var data = '{"message_type":3, "app_url":"'+app_url+'", "message":"'+message+'", "user_id":"'+user_id+'", "user_name":"'+user_name+'"}';
        ws.send(data);
    });
    $(document).keydown(function(e) {
        if (e.keyCode == 13) {
            $("#send").trigger('click');
        }
    });

    QxEmotion($('#emotion'), $('#message'));
});