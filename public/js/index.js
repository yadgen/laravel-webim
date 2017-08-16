var client_id = 0;
var userList = {};

$(function () {
    var message_block_height = 92;

    var ws = $.WebSocket("ws://" + server + ":" + port + "");

    ws.onopen = function () {
        console.log("connect webim server success.");

        var msg = new Object();
        msg.cmd = 'login';
        msg.user_id = user.id;
        msg.user_name = user.user_name;
        msg.user_avatar = user.user_avatar;
        ws.send($.toJSON(msg));
    };

    ws.onmessage = function (e) {
        var data = $.evalJSON(e.data);
        var cmd = data.cmd;

        if (cmd == 'login') {
            client_id = data.fd;
            ws.send($.toJSON({cmd: 'getOnline'}));
        } else if (cmd == 'getOnline') {
            showOnlineList(data);
        } else if (cmd == 'getHistory') {

        } else if (cmd == 'newUser') {
            showNewUser(data);
        } else if (cmd == 'fromMsg') {
            showNewMsg(data);
        } else if (cmd == 'offline') {
            var cid = data.fd;
            delUser(cid);
            showNewMsg(data);
        }
    };

    ws.onclose = function (e) {
        layer.open({
            id: 'layer_webim_server_close',
            title: 0,
            resize: 0,
            btn: ['刷新'],
            btnAlign: 'c',
            content: '连接已断开，请刷新页面重新登录。',
            yes: function (index, layero) {
                window.location.reload();
            },
            cancel: function (index, layero) {
                layer.close(index);
            }
        });
    };

    ws.onerror = function (e) {
        layer.open({
            id: 'layer_webim_server_close',
            title: 0,
            resize: 0,
            btn: ['确定'],
            btnAlign: 'c',
            content: '服务器[' + server + ']: 拒绝了连接，请检查服务器是否启动。',
            yes: function (index, layero) {
                layer.close(index);
            },
            cancel: function (index, layero) {
                layer.close(index);
            }
        });
        console.log("onerror: " + e.data);
    };

    $("#send").click(function () {
        var message = $("#message").val();
        if (message == "") {
            return false;
        }
        $("#message").val("");

        var msg = {};

        msg.cmd = 'message';
        msg.message = message;
        ws.send($.toJSON(msg));
    });

    $(document).keydown(function (e) {
        if (e.keyCode == 13) {
            $("#send").trigger('click');
        }
    });
});

function showOnlineList(dataObj) {
    var userLi = '';

    for (var i = 0; i < dataObj.list.length; i++) {
        userLi = userLi + "<li id='user-cartoon-man' class='online userLi" + dataObj.list[i].fd + "'>" +
            "<a href='javascript:;'>" +
            "<img src='" + dataObj.list[i].user_avatar + "'>" +
            "<span>" + dataObj.list[i].user_name + "</span>" +
            "</a>" +
            "</li>";

        userList[dataObj.list[i].fd] = dataObj.list[i].user_name;
    }

    $('.userList').html(userLi);
}

function showNewUser(dataObj) {
    if (!userList[dataObj.fd]) {
        userList[dataObj.fd] = dataObj.user_name;

        if (dataObj.fd != client_id) {
            $('.userList').append(
                "<li id='user-cartoon-man' class='online userLi" + dataObj.fd + "'>" +
                "<a href='javascript:;'>" +
                "<img src='" + dataObj.user_avatar + "'>" +
                "<span>" + dataObj.user_name + "</span>" +
                "</a>" +
                "</li>"
            );
        }
    }
}

function showNewMsg(dataObj) {
    var msgLi;

    if (dataObj.channel == 0) {
        msgLi = "<p class='offline warning'>" +
            "<span>" + dataObj.message + "<i class='time'>&nbsp;" + dataObj.time + "</span>" +
            "</p>";
    } else if (dataObj.channel == 1) {
        msgLi = "<p class='message_block'>" +
            "<img src='" + dataObj.user_avatar + "'>" +
            "<span class='msg-block'>" +
            "<strong>" + dataObj.user_name + "</strong>" +
            "<span class='time'>&nbsp;" + dataObj.time + "</span>" +
            "<span class='msg'>" + dataObj.message + "</span>" +
            "</span>" +
            "</p>";
    }
    $('.msgList').append(msgLi);
    $('#chat-messages')[0].scrollTop = $('#chat-messages')[0].scrollHeight;
}

function delUser(cid) {
    $('.userLi' + cid).remove();
    delete(userList[cid]);
}