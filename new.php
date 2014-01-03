<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <title>加入聊天室</title>
        <script type="text/javascript" src="http://code.jquery.com/jquery-1.9.1.js"></script>
        <script type="text/javascript">
            function setCookie(c_name, value, expiredays)
            {
                var exdate = new Date()
                exdate.setDate(exdate.getDate() + expiredays)
                document.cookie = c_name + "=" + escape(value) +
                        ((expiredays == null) ? "" : "; expires=" + exdate.toGMTString())
            }
            $(document).ready(function() {
                $("button").click(function() {
                    $.post("./server/do_new.php",
                            {
                                nickname: $("input").val()
                            },
                    function(data, status) {
                        if (data.addnew == 1) {
                            setCookie("ssid",data.ssid,30);
                            location.href = data.herf;
                        }
                        else
                            alert(data.msg);
                    });
                });
            });
        </script>
    </head>

    <body>
        <p>设置一个昵称:
            <input type="text" name="nickname" />
        </p>
        <p>
            <button type="button">确定</button>
        </p>
    </form>
</body>
</html>
