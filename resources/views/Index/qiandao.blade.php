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
<a href="">签到次数：{{$qian}}</a>
<input type="button" id="button" value="签到">
</body>
</html>
<script src="/js/jquery.min.js"></script>
<script>
    $("#button").click(function(){
        $.ajax({
            type: "post",
            data: {},
            dataType: "json",
            url: "http://laravel.lzy1109.com/qiandaoDo",
            success: function (msg) {
                if(msg.code==1){
                    history.go(0);
                    alert(msg.msg);
                }

            }
        })
    })
</script>