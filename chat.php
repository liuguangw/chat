<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <title>聊天室</title>
        <style type="text/css">
            tr,td,div,p,textarea{
                margin: 0px;
                padding: 0px;
            }
            #main {
                position: absolute;
                overflow: hidden;
                height: 100%;
                width: 100%;
                margin: 0px;
                padding: 0px;
                left: 0px;
                top: 0px;
                z-index: 1;
            }
            #msg_list{
                position: relative;
                overflow:auto;
                height: 85%;
                width: 100%;
                left: 0px;
                top: 0px;
                background-color: #AFAFAF;
            }
            #msg_input{
                position: relative;
                left: 0px;
                top: 0px;
                height: 15%;
                width: 100%;
            }
        </style>
        <script type="text/javascript" src="http://code.jquery.com/jquery-1.9.1.js"></script>
        <script type="text/javascript">
            var msg_id = 0;
            function upmsg(data, status) {
                if (data.newmsg > 0) {
                    $("#msg_list").append(data.msg).scrollTop($("#msg_list")[0].scrollHeight-$("#msg_list").height());
                    msg_id = data.msg_id;
                }
                $("#sss").change();
            }
            //
            function send_msg(data, status) {
                if (data.error > 0) {
                    $("#msg_list").append(data.msg);
                }
            }

            //
            $(document).ready(function() {
                $("#msg_input").keydown(function(event) {
                    if (event.which == 13) {
                        $.post("./server/accept_msg.php", {msg: $("#msg_input").val()}, send_msg);
                        $("#msg_input").val("");
                    }
                });
                $("#sss").change(function() {
                    $.post("./server/accept_select.php", {msg_id: msg_id}, upmsg);
                });
                $("#sss").change();
            });
        </script>
    </head>

    <body>
        <div id="sss" style="display:none"></div>
        <div id="main">
            <div id="msg_list"></div>
            <textarea id="msg_input">输入聊天内容</textarea>
            </div>
    </body>
</html>
