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
            <td>营业执照：</td>
            <td><input class="showbtn" type="file" id="goods_img"  name="goods_img" /></td>
            <input type="hidden" value="" id="img">
        </tr>
        <tr>
            <td><input   type="button" id="button" value="申请账号"></td>
        </tr>
    </table>
</body>
</html>
<script src="js/jquery.min.js"></script>
<script src="js/ajaxfileupload.js"></script>

<script>
    $(document).ready(function() {

        $("#goods_img").change(function () {
            var url = "http://laravel.lzy1109.com/uploadImg";
            $.ajaxFileUpload({
                type: "post",
                url: url,
                secureuri: false,
                fileElementId: "goods_img",
                dataType: "json",
                success: function (msg) {
                     alert(msg);
                    msg = msg;
                    $('#img').val(msg);
                }
            })
        })


        $("#button").click(function () {
            var data = {};
            var name = $("#name").val();
            var shui = $("#shui").val();
            var dui = $("#dui").val();
            var img = $("#img").val();
            var url="http://laravel.lzy1109.com/regpassDo";
            data.name = name;
            data.shui = shui;
            data.dui = dui;
            data.img = img;
            $.ajax({

                type: "post",
                data: data,
                dataType: "json",
                url: url,
                success: function (msg) {
                    if(msg.code==1){
                        alert(msg.msg);
                        location.href="http://laravel.lzy1109.com/loginpass";
                    }

                }
            })
        })
    })
</script>