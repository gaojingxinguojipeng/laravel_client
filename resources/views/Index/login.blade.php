<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
<table>
    <tr>
        <td>企业名称：</td>
        <td><input type="text" id="name" ></td>
    </tr>
    <tr>
        <td>税务号：</td>
        <td><input type="text" id="shui"></td>
    </tr>
    <tr>
        <td>对公账号：</td>
        <td><input type="text" id="dui"></td>
    </tr>

    <tr>
        <td><input   type="button" id="button" value="登录账号"></td>
    </tr>
</table>
</body>
</html>
<script src="js/jquery.min.js"></script>


<script>
    $(document).ready(function() {
        $("#button").click(function () {
            var data = {};
            var name = $("#name").val();
            var shui = $("#shui").val();
            var dui = $("#dui").val();
            var url="http://laravel.lzy1109.com/loginpassDo";
            data.name = name;
            data.shui = shui;
            data.dui = dui;
            $.ajax({
                type: "post",
                data: data,
                dataType: "json",
                url: url,
                success: function (msg) {
//                    alert(msg.code);
                    if(msg.code==1){
                        alert('APPID:'+msg.APPID);
                        alert('key:'+msg.key);
                    }else{
                        alert(msg.msg);
                    }
                }
            })
        })
    })
</script>